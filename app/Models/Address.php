<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['street', 'number', 'city_id', 'postcode', 'others'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function clinic()
    {
        return $this->hasMany(Clinic::class);
    }
}
