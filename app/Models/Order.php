<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderIem;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    public function order_items()
    {
        return $this->hasMany(OrderItem::class,'order_id')->with('product');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
}
