<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderItem;
use App\Models\CustomerAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';
    protected $primaryKey = 'order_number';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'order_number',
        'user_id',
        'courier_id',
        'address_id',
        'delivery_date',
        'delivery_time',
        'notes',
        'total_price',
        'payment_method',
        'payment_proof',
        'payment_status',
        'order_status',
        'order_at',
        'processed_at',
        'sent_at',
        'arrived_at',
        'arrival_proof',
        'completed_at',
        'canceled_at',
        'cancellation_reason',
        'canceled_by',
    ];

    protected $dates = [
        'order_at',
        'processed_at',
        'sent_at',
        'arrived_at',
        'completed_at',
        'canceled_at',
    ];

    /**
     * Relasi ke pengguna yang membuat order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke kurir (user) yang mengantarkan.
     */
    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    /**
     * Relasi ke alamat pengiriman.
     */
    public function address()
    {
        return $this->belongsTo(CustomerAddress::class);
    }

    /**
     * Relasi ke user yang membatalkan order.
     */
    public function canceledBy()
    {
        return $this->belongsTo(User::class, 'canceled_by');
    }

    /**
     * Relasi: Order memiliki banyak item.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_number', 'order_number');
    }
}
