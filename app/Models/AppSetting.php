<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;
    
    protected $table = 'app_settings';

    protected $fillable = [
        'setting_key', 'setting_value', 'description'
    ];
}
