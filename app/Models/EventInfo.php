<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Eventinfo extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "event_name", "seller_name","seller_address", "seller_zip","seller_country","seller_city","seller_vat","seller_footer","iva","invoice_number","symbol","invoice_pre"
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}