<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pcfLists() 
    {
        return $this->hasMany(PCFList::class);
    }

    public function pcfInclusions() 
    {
        return $this->hasMany(PCFInclusion::class);
    }
}
