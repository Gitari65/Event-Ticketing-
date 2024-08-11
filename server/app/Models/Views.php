<?php
use Illuminate\Database\Eloquent\Model as EloquentModel;
use App\Models\Ticket;
namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Views extends Authenticatable
{
    protected $table = 'views';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'TEventId',
        'Timedate',
        'userid'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'TEventId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
}