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
        'user_id',
        'date',
        'time'
    ];
    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
    public function views()
{
    return $this->hasMany(View::class);
}

public function images()
{
    return $this->hasMany(Image::class);
}

}
