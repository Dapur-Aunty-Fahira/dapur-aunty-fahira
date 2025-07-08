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

    protected $fillable = [
        'user_id',
        'menu_id',
        'quantity',
        'price',
    ];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Menu.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Accessor: total harga berdasarkan jumlah * harga.
     */
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->price;
    }

    /**
     * Scope: filter cart berdasarkan user.
     */
    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
