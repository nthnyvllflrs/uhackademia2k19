<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangayId extends Model
{
    protected $fillable = [
        'brgy_id_number', 'name'
    ];
}
