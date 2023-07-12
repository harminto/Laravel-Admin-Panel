<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteType extends Model
{
    use HasFactory;

    protected $table = 'waste_types';
    protected $fillable = [
        'waste_type_name',
        'description',
        'exchange_value',
    ];

    // Relasi jika diperlukan
    // public function transactions()
    // {
    //     return $this->hasMany(Transaction::class);
    // }
}
