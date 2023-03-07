<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Packages extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "pack_name", "price_normal", "price_early","price_all_normal", "price_all_early"
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}