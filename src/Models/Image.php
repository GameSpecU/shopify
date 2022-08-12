<?php

namespace Dan\Shopify\Models;

use Carbon\Carbon;

/**
 * Class Image.
 *
 * @property int $id
 * @property int $product_id
 * @property int $position
 * @property int $width
 * @property int $height
 * @property string $src
 * @property array $variant_ids
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Image extends AbstractModel
{
    /** @var string $resource_name */
    public static string $resource_name = 'image';

    /** @var string $resource_name_many */
    public static string $resource_name_many = 'images';

    /** @var array $dates */
    protected array $dates = [
        'created_at',
        'updated_at',
    ];

    /** @var array $casts */
    protected array $casts = [
        'product_id'  => 'int',
        'position'    => 'int',
        'width'       => 'int',
        'height'      => 'int',
        'src'         => 'string',
        'variant_ids' => 'array',
    ];
}
