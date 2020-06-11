<?php

namespace Tests\Setup;

use App\Models\OrderHeader;
use App\Models\OrderLine;

class OrderFactory
{
    protected bool $lines = false;

    protected array $line_attributes = [];

    /**
     * @param $attributes
     *
     * @return $this
     */
    public function withLine($attributes): self
    {
        $this->lines = true;
        $this->line_attributes = $attributes;

        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes = [])
    {
        $order = factory(OrderHeader::class)->create($attributes);

        if ($this->lines) {
            factory(OrderLine::class)->create([
                'order_number' => $order,
                'product' => $this->line_attributes['product'],
                'quantity' => $this->line_attributes['quantity'],
                'stock_type' => $this->line_attributes['stock_type'],
            ]);
        }

        return $order;
    }
}
