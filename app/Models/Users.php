<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Users extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name", "contact", "email","password", "contract_file", "user_type", 
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}