<?php

namespace App\Models;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "carts";
    protected $primaryKey = "cart_id";

    protected $fillable = [
        'user_id',
        'menu_id',
        'quantity',
    ];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke model Menu.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'menu_id');
    }

    /**
     * Accessor: total harga berdasarkan jumlah * harga.
     */
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->menu->price;
    }

    /**
     * Scope: filter cart berdasarkan user.
     */
    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
