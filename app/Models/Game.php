<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function currentVersion(){
        return $this->hasOne(GameVersion::class)->latest('id');
    }

    public function gameVersions(){
        return $this->hasMany(GameVersion::class);
    }
}
