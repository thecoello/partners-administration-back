<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Invoices extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "user_id", "pricetype", "company_name","category", "location","quantity","vat","subtotal","iva","total","address","zip","country","invoice_number"
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}