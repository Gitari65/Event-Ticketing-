<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'user_id', 'count'];

    /**
     * Define the relationship between Views and Event.
     * Each view belongs to an event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Define the relationship between Views and User.
     * Each view belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
