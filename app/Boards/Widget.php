<?php

namespace App\Boards;

use Illuminate\Database\Eloquent\Model;

/**
 * The board widgets model
 */
class Widget extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['uid', 'title', 'type', 'position', 'settings', 'order', 'board_id', 'user_id'];

    /**
     * @var array
     */
    protected $casts = [
        'settings' => 'object',
        'order'    => 'integer',
        'board_id' => 'integer',
        'user_id'  => 'integer',
    ];
}
