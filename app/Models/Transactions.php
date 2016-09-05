<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';

    public function user()
    {
        return $this->belongsTo('App\Models\Users', 'user_id');
    }

}
