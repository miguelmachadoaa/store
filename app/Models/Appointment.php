<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'appointment_date',
        'appointment_time',
        'status',
        'customer_notes',
        'admin_notes',
        'confirmed_at',
        'completed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time');
    }

    public function scopePast($query)
    {
        return $query->where('appointment_date', '<', now()->toDateString())
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc');
    }

    public function confirm()
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    public function complete()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }

    public function getFormattedDateAttribute()
    {
        return $this->appointment_date->format('d/m/Y');
    }

    public function getFormattedTimeAttribute()
    {
        return \Carbon\Carbon::createFromFormat('H:i:s', $this->appointment_time)->format('h:i A');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>',
            'confirmed' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Confirmada</span>',
            'completed' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completada</span>',
            'cancelled' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Cancelada</span>',
        ];

        return $badges[$this->status] ?? '';
    }
}
