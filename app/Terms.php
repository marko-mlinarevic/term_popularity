<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','title', 'grade',
    ];
}
