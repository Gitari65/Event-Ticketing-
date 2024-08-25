<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'image_path'
    ];

    /**
     * Define a relationship with the Event model.
     * Assuming you have an Event model that this Image belongs to.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
