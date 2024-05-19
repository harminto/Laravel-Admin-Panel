<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HakAkses extends Model
{
    use HasFactory;

    protected $table = 'role_menu';
    public $incrementing = false;
    protected $primaryKey = ['role_id', 'menu_id'];
    public $timestamps = false;
    protected $fillable = [
        'menu_id',
        'role_id',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array'
    ];
    
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function getKeyType()
    {
        return 'string';
    }

    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        return $this->original[$keyName] ?? $this->getAttribute($keyName);
    }
}
