<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'ip_address',
        'user_agent',
        'status',
        'type',
        'url',
        'method',
        'payload',
        'response_code',
        'response_body',
        'error_message',
        'error_code',
        'session_id',
        'trace_id',
        'correlation_id',
        'environment',
        'application',
        'version'
    ];
    protected $casts = [
        'payload' => 'array',
        'response_body' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
