<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = "id";
    protected $table = "menus";
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
        return $this->belongsTo(Category::class);
    }
}
