<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\DeliveryMethod.
 *
 * @mixin Eloquent
 * @property int $id
 * @property string $code
 * @property string $title
 * @property string $identifier
 * @property int $price_low
 * @property int $price
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class DeliveryMethod extends Model
{
    use LogsActivity;

    protected $fillable = ['code', 'title', 'identifier', 'price_low', 'price'];

    protected static $logAttributes = ['id', 'code', 'title', 'identifier', 'price_low', 'price'];

    /**
     * Get delivery details for the given code.
     *
     * @param $code
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public static function details($code)
    {
        return self::where('code', $code)->first();
    }

    /**
     * Store a new delivery method in the database.
     *
     * @param $request
     *
     * @return bool
     */
    public static function store($request): bool
    {
        $delivery = new self;

        $delivery->code = $request->code;
        $delivery->title = $request->title;
        $delivery->identifier = $request->identifier;
        $delivery->price_low = $request->price_low;
        $delivery->price = $request->price;

        return $delivery->save();
    }

    /**
     * Edit an existing delivery method.
     *
     * @param $request
     *
     * @return \App\Models\DeliveryMethod|\App\Models\DeliveryMethod[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public static function edit($request)
    {
        $delivery = self::findOrFail($request->id);

        $delivery->update([
            'code' => $request->code,
            'title' => $request->title,
            'identifier' => $request->identifier,
            'price_low' => $request->price_low,
            'price' => $request->price,
        ]);

        return $delivery;
    }
}
