<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\CustomerDiscount.
 *
 * @mixin Eloquent
 * @property string $customer_code
 * @property float $percent
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class CustomerDiscount extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['customer_code', 'percent'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_code', 'code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function show()
    {
        return self::with('customer')->whereHas('customer')->orderBy('customer_code', 'asc')->get();
    }

    /**
     * @param $customer
     * @param $percent
     * @param $id
     *
     * @return bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|void|null
     */
    public static function store($customer, $percent, $id = null)
    {
        if ($id) {
            return self::edit($percent, $id);
        }

        $discount = new self;

        $discount->customer_code = $customer;
        $discount->percent = $percent;

        if ($discount->save()) {
            return self::with('customer')->find($discount->id);
        }

        return false;
    }

    /**
     * @param $percent
     * @param $id
     *
     * @return bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public static function edit($percent, $id)
    {
        $discount = self::find($id);

        $discount->percent = $percent;

        if ($discount->save()) {
            return self::with('customer')->find($discount->id);
        }

        return false;
    }
}
