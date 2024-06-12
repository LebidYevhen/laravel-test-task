<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';

    protected $fillable = [
        'name',
        'poster',
        'event_date',
        'venue_id'
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function venue()
    {
        return $this->hasOne(Venue::class);
    }
}
