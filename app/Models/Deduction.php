<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'medical',
        'retirement',
        'donation',
        'education',
    ];

    protected $hidden = ['id', 'updated_at', 'created_at', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
