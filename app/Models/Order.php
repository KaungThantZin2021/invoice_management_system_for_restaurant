<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    public function orderable()
    {
        return $this->morphTo();
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopePending()
    {
        return $this->where('status', 'pending');
    }

    public function scopeConfirm()
    {
        return $this->where('status', 'confirm');
    }

    public function scopeCancel()
    {
        return $this->where('status', 'cancel');
    }

    public function isPending()
    {
        return $this->status == 'pending';
    }

    public function isConfirm()
    {
        return $this->status == 'confirm';
    }

    public function isCancel()
    {
        return $this->status == 'cancel';
    }
}
