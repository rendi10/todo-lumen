<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    /**
     * @var string
     */
    protected $table = 'todo';

    /**
     * @var array
     */
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama', 'status',
    ];
}
