<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "order_items";
    protected $primaryKey = "id";
    protected $fillable = [
        "order_number",
        "menu_id",
        "quantity",
        "price",
        "total_price",
        "notes",

    ];

    /**
     * Relationship: OrderItem belongs to an Order via order_number.
     * Ensure 'order_number' in orders table is unique.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_number', 'order_number');
    }

    /**
     * Relationship: OrderItem belongs to a Menu.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Optional accessor if you ever want dynamic total_price (instead of stored one).
     */
    public function getComputedTotalPriceAttribute()
    {
        return $this->quantity * $this->price;
    }
}
