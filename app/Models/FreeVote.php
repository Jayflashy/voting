<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeVote extends Model
{
    use HasFactory;
    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
