<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    protected $fillable = [
        'user_id', 'name',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
