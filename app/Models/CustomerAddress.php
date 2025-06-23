<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = "id";
    protected $table = "customer_addresses";
    protected $fillable = [
        'user_id',
        'recipient_name',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'coordinates',
        'notes',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke user pemilik alamat.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
