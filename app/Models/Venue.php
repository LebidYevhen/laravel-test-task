<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'venue';

    protected $fillable = [
      'name'
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
