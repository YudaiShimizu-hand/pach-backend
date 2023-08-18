<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
