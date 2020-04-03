<?php

namespace App\Models;

use Eloquent;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Response;
use Storage;

/**
 * App\Models\Basket.
 *
 * @mixin Eloquent
 *
 * @property int $user_id
 * @property string $customer_code
 * @property string $product
 * @property int $quantity
 */
class Basket extends Model
{
    protected $table = 'basket';

    public $timestamps = false;

    /**
     * Return product relationship on product code from basket.
     *
     * @return BelongsTo
     */
    public function productDetails(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product', 'product');
    }

    /**
     * Return relationship for prices.
     *
     * @return BelongsTo
     */
    public function prices(): BelongsTo
    {
        return $this->belongsTo(Price::class, 'product', 'product')->where('prices.customer_code', auth()->user()->customer->code);
    }

    /**
     * Return all basket lines based on customer code.
     *
     * @param null $shipping_code
     *
     * @return Basket[]|Collection
     */
    public static function show($shipping_code = null): array
    {
        $lines = static::selectRaw('basket.product as product, basket.customer_code as customer_code,
                                                    basket.quantity as quantity, price, break1, price1, break2, price2,
                                                    break3, price3, name, uom, not_sold, stock, type')
            ->where('basket.customer_code', auth()->user()->customer->code)
            ->where('basket.user_id', auth()->user()->id)
            ->join('prices', 'basket.product', '=', 'prices.product')
            ->where('prices.customer_code', auth()->user()->customer->code)
            ->join('products', 'basket.product', '=', 'products.code')
            ->get();

        $goods_total = 0;
        $potential_saving_total = 0;
        $product_lines = [];

        foreach ($lines as $line) {
            // Check for any bulk discounts and adjust the prices to match if found.
            switch (true) {
                case ($line->quantity >= $line->break3) && ($line->price3 > 0):
                    $net_price = $line->price3;
                    $next_bulk_qty = null;
                    $next_bulk_saving = null;
                    break;
                case ($line->quantity >= $line->break2) && ($line->price2 > 0):
                    $net_price = $line->price2;
                    $next_bulk_qty = ($line->quantity >= ($line->break3 * 0.75)) ? ($line->break3 - $line->quantity) : null;
                    $next_bulk_saving = $net_price - $line->price3;
                    break;
                case ($line->quantity >= $line->break1) && ($line->price1 > 0):
                    $net_price = $line->price1;
                    $next_bulk_qty = ($line->quantity >= ($line->break2 * 0.75)) ? ($line->break2 - $line->quantity) : null;
                    $next_bulk_saving = $net_price - $line->price2;
                    break;
                default:
                    $next_bulk_qty = ($line->quantity >= ($line->break1 * 0.75)) ? ($line->break1 - $line->quantity) : null;
                    $net_price = $line->price;
                    $next_bulk_saving = $net_price - $line->price1;
            }

            $goods_total += (discount($net_price) * $line->quantity);

            // Check for a matching product image.
            if (Storage::disk('public')->exists('product_images/'.$line->product.'.png')) {
                $image = asset('product_images/'.$line->product.'.png');
            } else {
                $image = asset('images/no-image.png');
            }

            $product_lines[] = [
                'product' => $line->product,
                'type' => $line->type,
                'name' => $line->name,
                'uom' => $line->uom,
                'stock' => $line->stock,
                'image' => $image,
                'quantity' => $line->quantity,
                'discount' => discountPercent(),
                'net_price' => currency(number_format(discount($net_price), 4)),
                'price' => currency(discount($net_price) * $line->quantity, 2),
                'unit_price' => discount($net_price),
                'next_bulk' => [
                    'qty_away' => $next_bulk_qty,
                    'saving' => currency($next_bulk_qty + $line->quantity * $next_bulk_saving, 2),
                ],
                'potential_saving' => $next_bulk_qty > 0,
            ];

            if ($next_bulk_qty > 0) {
                $potential_saving_total += $next_bulk_qty + $line->quantity * $next_bulk_saving;
            }
        }

        if ($shipping_code) {
            $delivery_method = DeliveryMethod::details($shipping_code);
        } else {
            $delivery_method = null;
        }

        $small_order_charge = smallOrderCharge($goods_total, $delivery_method);

        if ($delivery_method) {
            $shipping_value = $small_order_charge['charge'] > 0 ? $delivery_method->price_low : $delivery_method->price;
        } else {
            $shipping_value = 0;
        }

        return [
            'currency' => currency(),
            'summary' => [
                'goods_total' => currency($goods_total, 2),
                'shipping' => [
                    'code' => $delivery_method->code ?? null,
                    'identifier' => $delivery_method->identifier ?? null,
                    'cost' => currency($shipping_value, 2),
                ],
                'sub_total' => currency($goods_total + $shipping_value, 2),
                'small_order_charge' => currency($small_order_charge['charge'], 2),
                'small_order_rules' => $small_order_charge,
                'vat' => currency(vatAmount($goods_total + $small_order_charge['charge'] + $shipping_value), 2),
                'total' => currency(vatIncluded($goods_total + $small_order_charge['charge'] + $shipping_value), 2),
            ],
            'line_count' => count($product_lines),
            'lines' => $product_lines,
            'potential_saving' => in_array(true, array_column($product_lines, 'potential_saving'), false),
            'potential_saving_total' => currency($potential_saving_total, 2),
        ];
    }

    /**
     * Add array of order lines into customers basket.
     *
     * @param $order_lines
     * @param bool $update
     *
     * @return mixed
     */
    public static function store($order_lines, $update = false)
    {
        $user_id = auth()->user()->id;
        $customer_code = auth()->user()->customer->code;

        foreach ($order_lines as $line) {
            // Check that the customer can buy the product.
            $customer_can_buy = Product::show($line['product']);

            if ($customer_can_buy) {
                $product = static::exists($line['product']);
                $line['user_id'] = $user_id;
                $line['customer_code'] = $customer_code;

                if ($product) {
                    $basket_quantity = $product->quantity;

                    if ($update) {
                        self::where('product', $line['product'])->update(['quantity' => $line['quantity']]);
                    } else {
                        self::where('product', $line['product'])->update(['quantity' => $basket_quantity + $line['quantity']]);
                    }
                } else {
                    self::insert($line);
                }
            }
        }

        return ['basket_updated' => true];
    }

    /**
     * Checks if a product already exists in the customers basket.
     *
     * @param $product_code
     *
     * @return Basket|Model|object|null
     */
    public static function exists($product_code)
    {
        return self::where('customer_code', auth()->user()->customer->code)->where('user_id', auth()->user()->id)->where('product', $product_code)->first();
    }

    /**
     * Remove all items from the basket for the logged in customer.
     *
     * @return bool|int|null
     * @throws Exception
     */
    public static function clear()
    {
        return self::where('customer_code', auth()->user()->customer->code)->where('user_id', auth()->user()->id)->delete();
    }

    /**
     * Delete an individual product line from the basket.
     *
     * @param $product
     *
     * @return ResponseFactory|Response
     */
    public static function destroyLine($product)
    {
        return self::where('customer_code', auth()->user()->customer->code)->where('user_id', auth()->user()->id)->where('product', $product)->delete();
    }

    /**
     * Update the quantity for a given product line in the basket.
     *
     * @param $product
     * @param $quantity
     *
     * @return int
     */
    public static function updateLine($product, $quantity): int
    {
        return self::where('customer_code', auth()->user()->customer->code)->where('user_id', auth()->user()->id)->where('product', $product)->update(['quantity' => $quantity]);
    }
}
