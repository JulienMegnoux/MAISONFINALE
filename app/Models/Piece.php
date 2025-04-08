<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appareils()
    {
        return $this->hasMany(Appareil::class);
    }
}
