<?php

namespace App\Models;

use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Auth;

/**
 * App\Models\Addresses
 *
 * @mixin Eloquent
 */
class Addresses extends Model
{
    protected $guarded = [];

    /**
     * @return mixed
     */
    public static function show()
    {
        return (new Addresses)->where('customer_code', Auth::user()->customer->customer_code)->orderBy('default', 'desc')->paginate(5);
    }

    /**
     * @param $address_id
     * @return mixed
     */
    public static function details($address_id)
    {
        return (new Addresses)->where('customer_code', Auth::user()->customer->customer_code)->where('id', $address_id)->first();
    }

    /**
     * @param $address
     * @return mixed
     */
    public static function store($address)
    {
        $address['customer_code'] = Auth::user()->customer->customer_code;
        $address['created_at'] = date('Y-m-d H:i:s');

        $create_address = (new Addresses)->insertGetId($address);

        if ($create_address && $address['default']) {
            static::setDefault($create_address);
        }

        return $create_address;
    }

    /**
     * @param $id
     * @param $address
     * @return mixed
     */
    public static function edit($id, $address)
    {
        $address['updated_at'] = date('Y-m-d H:i:s');

        $updated = (new Addresses)->where('id', $id)->update($address);

        if ($updated && $address['default']) {
            static::setDefault($id);
        }

        return $updated;
    }

    /**
     * @return mixed
     */
    public static function removeDefaults()
    {
        return (new Addresses)->where('customer_code', Auth::user()->customer->customer_code)->update(['default' => 0]);
    }

    /**
     * @param $address_id
     * @return mixed
     */
    public static function setDefault($address_id)
    {
        static::removeDefaults();

        return (new Addresses)->where('id', $address_id)->update(['default' => 1]);
    }

    /**
     * @return mixed
     */
    public static function getDefault()
    {
        return (new Addresses)->where('customer_code', Auth::user()->customer->customer_code)->where('default', 1)->first();
    }

    /**
     * @param $address_id
     * @return mixed
     */
    public static function canEdit($address_id)
    {
        return (new Addresses)->where('customer_code', Auth::user()->customer->customer_code)->where('id', $address_id)->first();
    }

    /**
     * @param array|Collection|int $address_id
     * @return int
     * @throws Exception
     */
    public static function destroy($address_id)
    {
        return (new Addresses)->where('id', $address_id)->delete();
    }
}
