<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * App\UserCustomers
 *
 * @mixin Eloquent
 */
class UserCustomers extends Model
{
    /**
     * Check that a user has access to a customer.
     *
     * @param $customer_code
     * @return mixed
     */
    public static function check($customer_code)
    {
        return (new UserCustomers)->where('customer_code', $customer_code)
            ->where('user_id', Auth::user()->id)->first();
    }

    /**
     * Delete the user customers from passed ID.
     *
     * @param array|Collection|int $id
     * @return int
     */
    public static function destroy($id)
    {
        return (new UserCustomers)->where('id', $id)->delete();
    }

    /**
     * Store an extra customer for the given user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public static function store(Request $request)
    {
        $id = $request->user_id;
        $request->customer_code = strtoupper($request->customer_code);

        $request->validate([
            'customer_code' => 'required|exists:customers|unique:user_customers,customer_code,NULL,id,user_id,' . $id
        ]);

        $extra_customer = [
            'user_id' => $id,
            'customer_code' => strtoupper($request->customer_code),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $created = (new UserCustomers)->insertGetId($extra_customer);

        if ($created) {
            return response()->json([
                'success' => true,
                'error' => null,
                'id' => $created,
                'customer_code' => $extra_customer['customer_code'],
            ], 200);
        }

        return response()->json([
            'success' => true,
            'error' => 'Unable to add extra customer, please try again',
            'id' => null,
            'customer_code' => null,
        ], 422);
    }
}
