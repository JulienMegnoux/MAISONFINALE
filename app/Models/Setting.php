<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'platform_name',
        'logo_path',
        'theme_color',
        'welcome_message',
    ];
}
