<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Product.
 *
 * @mixin \Eloquent
 *
 * @property string $product
 * @property int $product_qty
 * @property string $promotion_product
 * @property int $promotion_qty
 * @property string $claim_type
 * @property int $max_claims
 * @property string $restrictions
 * @property string $buying_groups
 * @property string $price_lists
 * @property string $discount_codes
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $deleted_at
 */
class Promotion extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'product',
        'product_qty',
        'promotion_product',
        'promotion_qty',
        'claim_type',
        'max_claims',
        'restrictions',
        'buying_groups',
        'price_lists',
        'discount_codes',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'buying_groups' => 'array',
        'price_lists' => 'array',
        'discount_codes' => 'array',
        'start_date' => 'date:d-m-Y',
        'end_date' => 'date:d-m-Y',
    ];

    protected static $logFillable = true;

    /**
     * Set the format that is received for the start date
     *
     * @param $value
     *
     * @throws \Exception
     */
    public function setStartDateAttribute($value): void
    {
        $this->attributes['start_date'] = (new Carbon($value))->format('Y-m-d');
    }

    /**
     * Set the format that is received for the end date.
     *
     * @param $value
     *
     * @throws \Exception
     */
    public function setEndDateAttribute($value): void
    {
        $this->attributes['end_date'] = $value ? (new Carbon($value))->format('Y-m-d') : null;
    }

    /**
     * Return (paginate) all promotions that have not yet ended.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function notExpired()
    {
        return self::where('end_date', null)->orWhere('end_date', '>=', Carbon::now()->format('Y-m-d'))->get();
    }
}
