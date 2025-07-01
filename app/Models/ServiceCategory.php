<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ServiceCategory extends Model
{
    protected $fillable = ['name'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
