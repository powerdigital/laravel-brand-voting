<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'company_id'
    ];

    /**
     * Flag to set if created/updates fields required.
     *
     * @var boolean
     */
    public $timestamps = null;
}
