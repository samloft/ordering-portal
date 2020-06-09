<?php

namespace Tests\Setup;

use App\Models\OrderTrackingHeader;
use App\Models\OrderTrackingLine;

class OrderTrackingFactory
{
    protected $lines = false;

    protected $count = 0;

    public function __construct($count = 1)
    {
        $this->count = $count;
    }

    /**
     * @return $this
     */
    public function withLines(): self
    {
        $this->lines = true;

        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes = [])
    {
        $headers = factory(OrderTrackingHeader::class, $this->count)->create($attributes);

        if ($this->lines) {
            foreach ($headers as $header) {
                $products = (new ProductFactory())->withPrices(auth()->user()->customer->code)->create();

                $line_number = 1;

                foreach ($products as $product) {
                    $test = factory(OrderTrackingLine::class)->create([
                        'order_number' => $header->order_number,
                        'order_line_no' => $line_number,
                        'product' => $product->code,
                    ]);

                    $line_number++;
                }
            }
        }

        return $headers;
    }
}
