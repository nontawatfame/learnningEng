<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    public function vocabulary() {
        return $this->belongsTo(Vocabulary::class,'id','vocabulary_id');
    }
}
