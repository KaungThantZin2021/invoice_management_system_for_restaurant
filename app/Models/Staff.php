<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    public function getProfileImageUrlAttribute()
    {
        return Storage::url('staff/' . $this->profile_image);
    }
}
