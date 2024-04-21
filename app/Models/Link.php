<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'links';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'original_url',
        'token',
        'expire_at',
        'used_count',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'expire_at' => 'datetime',
    ];
}
