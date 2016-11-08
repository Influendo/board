<?php

namespace App\Boards;

use Illuminate\Database\Eloquent\Model;

/**
 * The boards model
 */
class Board extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['uid', 'title', 'user_id', 'status', 'privacy'];

    /**
     * @var array
     */
    protected $casts = [
        'user_id'  => 'integer',
    ];
}
