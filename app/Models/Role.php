<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    // Relasi Many-to-Many dengan User
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'role_menu');
    }

}
