<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory;
    protected $fillable = ['vocabulary_name'];

    public function translation() {
        return $this->hasMany(Translation::class,'vocabulary_id','id');
    }
}
