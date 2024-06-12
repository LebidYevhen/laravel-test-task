<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var class-string<\Illuminate\Database\Eloquent\Model>
   */
    protected $model = Venue::class;

  /**
   * Run the database seeds.
   */
    public function run(): void
    {
        Venue::factory(10)->create();
    }
}
