<?php

namespace App\Models;

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
}
