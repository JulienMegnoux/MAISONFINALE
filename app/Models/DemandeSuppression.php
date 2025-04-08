<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeSuppression extends Model
{
    use HasFactory;
    
    protected $table = 'demande_suppression'; // ← force Laravel à utiliser le bon nom

    protected $fillable = ['objet_connecte_id', 'user_id'];
}
