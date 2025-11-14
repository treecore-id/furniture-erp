<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wood;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /* Seed the application's database. */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
        ]);

        Wood::create(['name' => 'Teak', 'description' => 'Tectona Grandis — Native to South Asia but extensively cultivated on plantations across tropical regions in Africa, Asia, and Latin America. The heartwood starts as golden to medium brown, darkening over time. Typically grows between 30 and 40 meters tall, with a trunk diameter of 1 to 1.5 meters.']);
        Wood::create(['name' => 'Mahogany', 'description' => 'Swietenia macrophylla — Native to South America, Mexico, and Central America. It has also been introduced and cultivated in the Philippines, Singapore, Malaysia, Hawaii, and various plantations worldwide. Ranges from pale pinkish brown to rich reddish brown, deepening over time. It exhibits chatoyancy, an optical effect enhancing its visual appeal. Grows between 46 to 60 meters tall, with trunk diameters of 1 to 2 meters.']);
        Wood::create(['name' => 'Bangkirai', 'description' => 'Shorea spp. — Native to Southeast Asia, from northern India to Malaysia, Indonesia, and the Philippines. Color can be highly variable depending upon the species: ranging from a pale straw color, to a darker reddish brown. 150-200 ft (45-60 m) tall, 3-6 ft (1-2 m) trunk diameter.']);
    }
}
