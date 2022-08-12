<?php

namespace Dan\Shopify\Models;

use Carbon\Carbon;
use stdClass;

/**
 * Class Fulfillment.
 *
 * @property int $id
 * @property int $order_id
 * @property string $status
 * @property string $service
 * @property string|null $tracking_company
 * @property string|null $shipment_status
 * @property int $location_id
 * @property string $tracking_number
 * @property array $tracking_numbers
 * @property string $tracking_url
 * @property array $tracking_urls
 * @property stdClass $receipt
 * @property string $name
 * @property string $admin_graphql_api_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Fulfillment extends AbstractModel
{
    /** @var string $resource_name */
    public static string $resource_name = 'fulfillment';

    /** @var string $resource_name_many */
    public static string $resource_name_many = 'fulfillments';

    /** @var array $dates */
    protected array $dates = [
        'closed_at',
        'created_at',
        'updated_at',
        'cancelled_at',
        'processed_at',
    ];

    /** @var array $casts */
    protected array $casts = [
        'id'                   => 'integer',
        'order_id'             => 'integer',
        'status'               => 'string',
        'service'              => 'string',
        'tracking_company'     => 'string',
        'shipment_status'      => 'string',
        'int'                  => 'location_id',
        'tracking_number'      => 'string',
        'tracking_numbers'     => 'array',
        'tracking_url'         => 'string',
        'tracking_urls'        => 'array',
        'receipt'              => 'object',
        'name'                 => 'string',
        'admin_graphql_api_id' => 'string',
    ];
}
