<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appareil extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'piece_id'];

    public function piece()
    {
        return $this->belongsTo(Piece::class);
    }
}
