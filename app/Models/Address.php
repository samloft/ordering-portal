<?php

namespace App\Models;

use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Address.
 *
 * @mixin Eloquent
 * @property int $id
 * @property string $customer_code
 * @property int $user_id
 * @property string $company_name
 * @property string $address_line_2
 * @property string $address_line_3
 * @property string $address_line_4
 * @property string $address_line_5
 * @property string $country
 * @property stirng $post_code
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Address extends Model
{
    use LogsActivity;

    protected static $logAttributes = [
        'id',
        'customer_code',
        'user_id',
        'company_name',
        'address_line_2',
        'address_line_3',
        'address_line_4',
        'address_line_5',
        'country',
        'post_code',
    ];

    protected $guarded = [];

    /**
     * @return mixed
     */
    public static function show()
    {
        return self::where('customer_code', auth()->user()->customer->code)->orderBy('created_at', 'desc')->paginate(5);
    }

    /**
     * @param $address_id
     *
     * @return mixed
     */
    public static function details($address_id)
    {
        return self::where('customer_code', auth()->user()->customer->code)->where('id', $address_id)->first();
    }

    /**
     * @param $address
     *
     * @return mixed
     */
    public static function store($address)
    {
        $address['customer_code'] = auth()->user()->customer->code;
        $address['user_id'] = auth()->user()->id;
        $address['created_at'] = date('Y-m-d H:i:s');

        return self::insertGetId($address);
    }

    /**
     * @param $id
     * @param $address
     *
     * @return mixed
     */
    public static function edit($id, $address)
    {
        $address['updated_at'] = date('Y-m-d H:i:s');

        return self::where('id', $id)->where('customer_code', auth()->user()->customer->code)->update($address);
    }

    /**
     * @param $address_id
     *
     * @return mixed
     */
    public static function canEdit($address_id)
    {
        return self::where('customer_code', auth()->user()->customer->code)->where('id', $address_id)->first();
    }

    /**
     * @param array|Collection|int $address_id
     *
     * @return int
     * @throws Exception
     */
    public static function destroy($address_id): int
    {
        return self::where('id', $address_id)->delete();
    }
}
