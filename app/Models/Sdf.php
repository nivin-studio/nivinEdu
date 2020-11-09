<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sdf extends Model
{

    protected $table = 'sdf';

    protected $fillable = [
        'id',
        'room_num',
        'people_num',
        'year',
        'month',
        'cold_water_this_num',
        'cold_water_last_num',
        'cold_water_policy',
        'cold_water_meter',
        'cold_water_cost',
        'hot_water_this_num',
        'hot_water_last_num',
        'hot_water_policy',
        'hot_water_meter',
        'hot_water_cost',
        'power_this_num',
        'power_last_num',
        'power_policy',
        'power_meter',
        'power_cost',
        'aircn_this_num',
        'aircn_last_num',
        'aircn_policy',
        'aircn_meter',
        'aircn_cost',
        'total_cost',
    ];
}
