<?php

namespace Dan\Shopify\Models;

use Carbon\Carbon;

/**
 * Class PriceRule.
 *
 * @property int    $id
 * @property int    $allocation_limit
 * @property string $allocation_method
 * @property string $customer_selection
 * @property array  $entitled_collection_ids
 * @property array  $entitled_country_ids
 * @property array  $entitled_product_ids
 * @property array  $entitled_variant_ids
 * @property bool   $once_per_customer
 * @property array  $prerequisite_collection_ids
 * @property array  $prerequisite_customer_ids
 * @property array  $prerequisite_product_ids
 * @property array  $prerequisite_quantity_range
 * @property array  $prerequisite_saved_search_ids
 * @property array  $prerequisite_shipping_price_range
 * @property array  $prerequisite_subtotal_range
 * @property array  $prerequisite_to_entitlement_quantity_ratio
 * @property array  $prerequisite_variant_ids
 * @property string $target_selection
 * @property string $target_type
 * @property int    $usage_limit
 * @property int    $value
 * @property string $value_type
 * @property Carbon $starts_at
 * @property Carbon $ends_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class PriceRule extends AbstractModel
{
    /** @var string $resource_name */
    public static string $resource_name = 'price_rule';

    /** @var string $resource_name_many */
    public static string $resource_name_many = 'price_rules';

    public const ALLOCATION_METHOD_ACROSS = 'across';
    public const ALLOCATION_METHOD_EACH = 'each';
    public const CUSTOMER_SELECTION_ALL = 'all';
    public const CUSTOMER_SELECTION_PREREQUISITE = 'prerequisite';
    public const TARGET_SELECTION_ALL = 'all';
    public const TARGET_SELECTION_ENTITLED = 'entitled';
    public const TARGET_TYPE_LINE_ITEM = 'line_item';
    public const TARGET_TYPE_SHIPPING_LINE = 'shipping_line';
    public const VALUE_TYPE_FIXED_AMOUNT = 'fixed_amount';
    public const VALUE_TYPE_PERCENTAGE = 'percentage';

    /** @var array $allocation_methods */
    public static array $allocation_methods = [
        self::ALLOCATION_METHOD_ACROSS,
        self::ALLOCATION_METHOD_EACH,
    ];

    /** @var array $customer_selections */
    public static array $customer_selections = [
        self::CUSTOMER_SELECTION_ALL,
        self::CUSTOMER_SELECTION_PREREQUISITE,
    ];

    /** @var array $target_selections */
    public static array $target_selections = [
        self::TARGET_SELECTION_ALL,
        self::TARGET_SELECTION_ENTITLED,
    ];

    /** @var array $target_types */
    public static $target_types = [
        self::TARGET_TYPE_LINE_ITEM,
        self::TARGET_TYPE_SHIPPING_LINE,
    ];

    /** @var array $value_types */
    public static $value_types = [
        self::VALUE_TYPE_FIXED_AMOUNT,
        self::VALUE_TYPE_PERCENTAGE,
    ];

    /** @var array $casts */
    protected array $casts = [
        'entitled_collection_ids'           => 'array',
        'entitled_country_ids'              => 'array',
        'entitled_product_ids'              => 'array',
        'entitled_variant_ids'              => 'array',
        'once_per_customer'                 => 'boolean',
        'prerequisite_collection_ids'       => 'array',
        'prerequisite_customer_ids'         => 'array',
        'prerequisite_product_ids'          => 'array',
        'prerequisite_quantity_range'       => 'array',
        'prerequisite_saved_search_ids'     => 'array',
        'prerequisite_shipping_price_range' => 'array',
        'prerequisite_subtotal_range'       => 'array',
        'prerequisite_variant_ids'          => 'array',
    ];
}
