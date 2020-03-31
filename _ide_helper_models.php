<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */

namespace App\Models{
    /**
     * App\Models\OrderLine.
     *
     * @mixin Eloquent
     * @property string $order_number
     * @property string $product
     * @property string|null $description
     * @property int $quantity
     * @property string $stock_type
     * @property float $price
     * @property float $total
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine whereOrderNumber($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine wherePrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine whereProduct($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine whereQuantity($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine whereStockType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine whereTotal($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderLine whereUpdatedAt($value)
     */
    class OrderLine extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\UserCustomer.
     *
     * @mixin Eloquent
     * @property int $id
     * @property int $user_id
     * @property string $customer_code
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCustomer newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCustomer newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCustomer query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCustomer whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCustomer whereCustomerCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCustomer whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCustomer whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCustomer whereUserId($value)
     */
    class UserCustomer extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Category.
     *
     * @mixin Eloquent
     * @property string $product
     * @property string|null $level_1
     * @property string|null $level_2
     * @property string|null $level_3
     * @property string|null $level_4
     * @property string|null $level_5
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Price[] $prices
     * @property-read int|null $prices_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereLevel1($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereLevel2($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereLevel3($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereLevel4($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereLevel5($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereProduct($value)
     */
    class Category extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\CustomerDiscount.
     *
     * @mixin Eloquent
     * @property int $id
     * @property string $customer_code
     * @property float $percent
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Models\Customer $customer
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerDiscount newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerDiscount newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerDiscount query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerDiscount whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerDiscount whereCustomerCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerDiscount whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerDiscount wherePercent($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CustomerDiscount whereUpdatedAt($value)
     */
    class CustomerDiscount extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\HomeLink.
     *
     * @mixin Eloquent
     * @property int $id
     * @property string $type
     * @property string $name
     * @property string $image
     * @property string|null $link
     * @property string|null $file
     * @property int $position
     * @property string|null $style
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeLink newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeLink newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeLink query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeLink whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeLink whereFile($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeLink whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeLink whereImage($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeLink whereLink($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeLink whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeLink wherePosition($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeLink whereStyle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeLink whereType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeLink whereUpdatedAt($value)
     */
    class HomeLink extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\SavedBasket.
     *
     * @mixin Eloquent
     * @property string $id
     * @property string $customer_code
     * @property int $user_id
     * @property string $reference
     * @property string $product
     * @property int $quantity
     * @property string $created_at
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedBasket newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedBasket newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedBasket query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedBasket whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedBasket whereCustomerCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedBasket whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedBasket whereProduct($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedBasket whereQuantity($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedBasket whereReference($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedBasket whereUserId($value)
     */
    class SavedBasket extends \Eloquent
    {
    }
}

namespace App\Models{
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
     * @property string|null $address_line_4
     * @property string|null $address_line_5
     * @property string $country
     * @property string $post_code
     * @property int $default
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereAddressLine2($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereAddressLine3($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereAddressLine4($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereAddressLine5($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCompanyName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCountry($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereCustomerCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereDefault($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address wherePostCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address whereUserId($value)
     */
    class Address extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\ExpectedStock.
     *
     * @mixin \Eloquent
     * @property string $product
     * @property int $quantity
     * @property \Illuminate\Support\Carbon $due_date
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpectedStock newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpectedStock newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpectedStock query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpectedStock whereDueDate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpectedStock whereProduct($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpectedStock whereQuantity($value)
     */
    class ExpectedStock extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\OrderTrackingHeader.
     *
     * @mixin Eloquent
     * @property string $order_no
     * @property string $base_order
     * @property string $customer_order_no
     * @property string $status
     * @property string $type
     * @property string $customer_code
     * @property string $invoice_customer
     * @property string $date_received
     * @property string|null $date_required
     * @property string|null $date_despatched
     * @property string|null $date_invoiced
     * @property string|null $invoice_no
     * @property string $delivery_address1
     * @property string $delivery_address2
     * @property string $delivery_address3
     * @property string $delivery_address4
     * @property string $delivery_address5
     * @property float $value
     * @property string $invoice_address_1
     * @property string $invoice_address_2
     * @property string $invoice_address_3
     * @property string $invoice_address_4
     * @property string $consignment
     * @property float $vat_value
     * @property string $delivery_service
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderTrackingLine[] $lines
     * @property-read int|null $lines_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereBaseOrder($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereConsignment($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereCustomerCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereCustomerOrderNo($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereDateDespatched($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereDateInvoiced($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereDateReceived($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereDateRequired($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereDeliveryAddress1($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereDeliveryAddress2($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereDeliveryAddress3($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereDeliveryAddress4($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereDeliveryAddress5($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereDeliveryService($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereInvoiceAddress1($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereInvoiceAddress2($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereInvoiceAddress3($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereInvoiceAddress4($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereInvoiceCustomer($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereInvoiceNo($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereOrderNo($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereValue($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderTrackingHeader whereVatValue($value)
     */
    class OrderTrackingHeader extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\User.
     *
     * @mixin Eloquent
     * @property int $id
     * @property string $customer_code
     * @property string $email
     * @property string $password
     * @property string|null $password_updated
     * @property string|null $remember_token
     * @property string $name
     * @property string|null $telephone
     * @property string|null $mobile
     * @property int $admin
     * @property float $discount
     * @property int $can_order
     * @property string|null $api_token
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
     * @property-read int|null $addresses_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserCustomer[] $customers
     * @property-read int|null $customers_count
     * @property-read \App\Models\Customer|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null $customer
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
     * @property-read int|null $notifications_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAdmin($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereApiToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCanOrder($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCustomerCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDiscount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMobile($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePasswordUpdated($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereTelephone($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
     */
    class User extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\OrderHeader.
     *
     * @mixin Eloquent
     * @property string $order_number
     * @property string $customer_code
     * @property int $user_id
     * @property string $reference
     * @property string|null $notes
     * @property string $name
     * @property string|null $telephone
     * @property string|null $mobile
     * @property string $address_line_1
     * @property string $address_line_2
     * @property string|null $address_line_3
     * @property string|null $address_line_4
     * @property string $address_line_5
     * @property string $delivery_method
     * @property string $delivery_code
     * @property float $delivery_cost
     * @property float $small_order_charge
     * @property float $value
     * @property int $imported
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderLine[] $lines
     * @property-read int|null $lines_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereAddressLine1($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereAddressLine2($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereAddressLine3($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereAddressLine4($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereAddressLine5($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereCustomerCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereDeliveryCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereDeliveryCost($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereDeliveryMethod($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereImported($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereMobile($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereNotes($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereOrderNumber($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereReference($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereSmallOrderCharge($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereTelephone($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderHeader whereValue($value)
     */
    class OrderHeader extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Contact.
     *
     * @property int $id
     * @property string $name
     * @property string $email
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereUpdatedAt($value)
     */
    class Contact extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Customer.
     *
     * @mixin Eloquent
     * @property string $code
     * @property string $name
     * @property string|null $address_line_1
     * @property string|null $address_line_2
     * @property string|null $city
     * @property string|null $country
     * @property string|null $post_code
     * @property string|null $invoice_name
     * @property string|null $invoice_address_line_1
     * @property string|null $invoice_address_line_2
     * @property string|null $invoice_city
     * @property string|null $invoice_country
     * @property string|null $invoice_postcode
     * @property string $vat_flag
     * @property string $currency
     * @property-read \App\Models\CustomerDiscount $discount
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereAddressLine1($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereAddressLine2($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereCity($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereCountry($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereCurrency($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereInvoiceAddressLine1($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereInvoiceAddressLine2($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereInvoiceCity($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereInvoiceCountry($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereInvoiceName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereInvoicePostcode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer wherePostCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereVatFlag($value)
     */
    class Customer extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\CategoryImage.
     *
     * @mixin \Eloquent
     * @property int $id
     * @property string $image
     * @property string $level_1
     * @property string $level_2
     * @property string|null $level_3
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryImage newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryImage newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryImage query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryImage whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryImage whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryImage whereImage($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryImage whereLevel1($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryImage whereLevel2($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryImage whereLevel3($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryImage whereUpdatedAt($value)
     */
    class CategoryImage extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Price.
     *
     * @mixin Eloquent
     * @property string $customer_code
     * @property string $product
     * @property float $price
     * @property float|null $break1
     * @property float|null $price1
     * @property float|null $break2
     * @property float|null $price2
     * @property float|null $break3
     * @property float|null $price3
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereBreak1($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereBreak2($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereBreak3($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereCustomerCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price wherePrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price wherePrice1($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price wherePrice2($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price wherePrice3($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Price whereProduct($value)
     */
    class Price extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\AccountSummary.
     *
     * @mixin Eloquent
     * @property string $customer_code
     * @property string $item_no
     * @property string $reference
     * @property string $dated
     * @property string $due_date
     * @property float $unall_curr_amount
     * @property string $age
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountSummary newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountSummary newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountSummary query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountSummary whereAge($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountSummary whereCustomerCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountSummary whereDated($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountSummary whereDueDate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountSummary whereItemNo($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountSummary whereReference($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AccountSummary whereUnallCurrAmount($value)
     */
    class AccountSummary extends \Eloquent
    {
    }
}

namespace App\Models{
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
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeliveryMethod newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeliveryMethod newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeliveryMethod query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeliveryMethod whereCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeliveryMethod whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeliveryMethod whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeliveryMethod whereIdentifier($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeliveryMethod wherePrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeliveryMethod wherePriceLow($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeliveryMethod whereTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DeliveryMethod whereUpdatedAt($value)
     */
    class DeliveryMethod extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Page.
     *
     * @mixin Eloquent
     * @property int $id
     * @property string $name
     * @property string $description
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereUpdatedAt($value)
     */
    class Page extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\GlobalSettings.
     *
     * @mixin \Eloquent
     * @property int $id
     * @property string $key
     * @property string $value
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalSettings newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalSettings newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalSettings query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalSettings whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalSettings whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalSettings whereKey($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalSettings whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GlobalSettings whereValue($value)
     */
    class GlobalSettings extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Admin.
     *
     * @mixin \Eloquent
     * @property int $id
     * @property string $name
     * @property string $email
     * @property string $password
     * @property string|null $remember_token
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
     * @property-read int|null $notifications_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereUpdatedAt($value)
     */
    class Admin extends \Eloquent
    {
    }
}

namespace App\Models{
    /**
     * App\Models\OrderImport.
     *
     * @mixin Eloquent
     * @property int $user_id
     * @property string $customer_code
     * @property string $product
     * @property int $quantity
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderImport newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderImport newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderImport query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderImport whereCustomerCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderImport whereProduct($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderImport whereQuantity($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderImport whereUserId($value)
     */
    class OrderImport extends \Eloquent
    {
    }
}
