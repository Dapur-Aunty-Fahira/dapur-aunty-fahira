<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "menus";
    protected $primaryKey = "menu_id";

    protected $fillable = [
        'category_id',
        'name',
        'image',
        'description',
        'price',
        'min_order',
        'is_available',
        'is_popular',
        'is_new',
    ];

    /**
     * Relasi ke kategori menu.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Relasi: Menu bisa muncul di banyak item order.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'menu_id', 'menu_id');
    }

    /**
     * Accessor: Format harga dengan Rp (contoh: Rp10.000)
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }


}
