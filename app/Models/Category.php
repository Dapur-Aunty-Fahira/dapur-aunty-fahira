<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = "id";
    protected $table = "categories";
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    /**
     * Relasi ke menu yang termasuk dalam kategori ini.
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
