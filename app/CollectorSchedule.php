<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectorSchedule extends Model
{
    protected $fillable = [
        'barangay_id', 'date', 'time',
    ];

    public function barangay() {
        return $this->belongsTo('App\Barangay');
    }
}
