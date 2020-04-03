<?php

namespace Tests\Setup;

class AddressFactory
{
    /**
     * @return mixed
     */
    public function create()
    {
        return factory(__CLASS__)->create([
            'user_id' => auth()->user()->id,
            'customer_code' => auth()->user()->customer->code,
        ]);
    }
}
