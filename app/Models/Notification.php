<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Accessor: status dibaca (teks).
     * Contoh output: "Belum Dibaca" atau "Sudah Dibaca"
     */
    public function getIsReadTextAttribute()
    {
        return $this->is_read ? 'Sudah Dibaca' : 'Belum Dibaca';
    }

    /**
     * Accessor: potongan pesan (maks. 50 karakter).
     * Cocok untuk preview di UI.
     */
    public function getShortMessageAttribute()
    {
        return strlen($this->message) > 50
            ? substr($this->message, 0, 47) . '...'
            : $this->message;
    }
}
