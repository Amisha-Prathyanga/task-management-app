<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'due_date',
        'priority',
        'description',
        'is_completed',
        'is_paid',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
        'is_completed' => 'boolean',
        'is_paid' => 'boolean',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
