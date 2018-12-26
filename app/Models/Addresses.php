<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Addresses extends Model
{
    /**
     * @return mixed
     */
    public static function show()
    {
        return (new Addresses)->where('customer_code', Auth::user()->customer_code)->orderBy('default', 'desc')->paginate(5);
    }

    /**
     * @param $address_id
     * @return mixed
     */
    public static function details($address_id)
    {
        return (new Addresses)->where('customer_code', Auth::user()->customer_code)->where('id', $address_id)->first();
    }

    /**
     * @param $request
     * @return mixed
     */
    public static function store($request)
    {
        $address_details = [
            'customer_code' => Auth::user()->customer_code,
            'address_line_1' => $request->company_name,
            'address_line_2' => $request->address_line_2,
            'address_line_3' => $request->address_line_3,
            'address_line_4' => $request->address_line_4,
            'address_line_5' => $request->address_line_5,
            'country_id' => $request->country_id,
            'post_code' => $request->postcode,
            'default' => 0
        ];

        if ($request->id) {
            $address_details['updated_at'] = date('Y-m-d H:i:s');

            $update_address = (new Addresses)->where('id', $request->id)->update($address_details);

            if ($update_address && $request->default) {
                static::setDefault($request->id);
            }

            return $update_address;
        }

        $address_details['created_at'] = date('Y-m-d H:i:s');

        $create_address = (new Addresses)->insertGetId($address_details);

        if ($create_address && $request->default) {
            static::setDefault($create_address);
        }

        return $create_address;
    }

    /**
     * @return mixed
     */
    public static function removeDefaults()
    {
        return (new Addresses)->where('customer_code', Auth::user()->customer_code)->update(['default' => 0]);
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
        return (new Addresses)->where('customer_code', Auth::user()->customer_code)->where('default', 1)->first();
    }

    /**
     * @param $address_id
     * @return mixed
     */
    public static function canEdit($address_id)
    {
        return (new Addresses)->where('customer_code', Auth::user()->customer_code)->where('id', $address_id)->first();
    }

    /**
     * @param array|\Illuminate\Support\Collection|int $address_id
     * @return int
     */
    public static function destroy($address_id)
    {
        return (new Addresses)->where('id', $address_id)->delete();
    }
}
