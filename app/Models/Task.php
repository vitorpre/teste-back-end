<?php
/**
 * Created by PhpStorm.
 * User: Vitor
 * Date: 06/03/2023
 * Time: 10:54
 */

namespace App\Models;


class Task
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'conclusion_date'
    ];

    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'conclusion_date' => 'datetime:Y-m-d',
    ];
}
