<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

/**
 * App\Models\UserCustomer.
 *
 * @mixin \Eloquent
 *
 * @property int $id
 * @property int $user_id
 * @property string $customer_code
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class UserCustomer extends Model
{
    /**
     * Check that a user has access to a customer.
     *
     * @param $customer_code
     *
     * @return mixed
     */
    public static function check($customer_code)
    {
        return self::where('customer_code', $customer_code)->where('user_id', auth()->user()->id)->first();
    }

    /**
     * Delete the user customers from passed ID.
     *
     * @param array|Collection|int $id
     *
     * @return int
     *
     * @throws \Exception
     */
    public static function destroy($id): int
    {
        $user_customer = self::findOrFail($id);

        return $user_customer->delete();
    }

    /**
     * Store an extra customer for the given user.
     *
     * @return JsonResponse
     */
    public static function store(): JsonResponse
    {
        request()->validate([
            'code' => 'required|unique:user_customers,customer_code,NULL,id,user_id,'.request('id'),
        ]);

        $user_customer = new self;

        $user_customer->user_id = request('id');
        $user_customer->customer_code = request('code');

        $created = $user_customer->save();

        return response()->json([
            'success' => $created,
            'errors' => [$created ? '' : 'Unable to add extra customer, please try again'],
            'id' => $user_customer->id ?? null,
            'customer_code' => $user_customer->customer_code ?? null,
        ], $created ? 200 : 422);
    }
}
