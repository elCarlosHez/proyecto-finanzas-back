<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incomes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'type',
        'periodicity',
        'income_date',
        'user_id',
    ];

    protected $hidden = ['updated_at', 'created_at', 'id', 'user_id'];

    protected $casts = [
        'income_date' => 'date',
    ];
}
