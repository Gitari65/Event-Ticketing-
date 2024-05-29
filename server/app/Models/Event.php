<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
;

class Event extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'venue',
        'location',
        'user_id'
    ];
    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
}
