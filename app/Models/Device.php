<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Device
 *
 * @package App\Models
 */
class Device extends Model
{
    /** @var array $fillable */
    protected $fillable = [
        'device_id',
        'type',
        'version'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
