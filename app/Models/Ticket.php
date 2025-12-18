<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'name',
        'email',
        'issue_type',
        'description',
        'status',
        'assigned_to',
    ];

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
