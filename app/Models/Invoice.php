<?php

namespace App\Models;

use App\Models\Order;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    public function invoiceable()
    {
        return $this->morphTo();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
