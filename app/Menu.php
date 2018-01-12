<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'vendor_id'];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
