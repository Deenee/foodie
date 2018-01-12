<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['name', 'location', 'phone_number'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }
}
