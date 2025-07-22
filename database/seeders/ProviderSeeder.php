<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Example service names for searching
        $serviceNames = [
            'Plumbing', 'Electrician', 'Gardening', 'Carpentry', 'Cleaning',
            'Painting', 'Landscaping', 'Tutoring', 'Babysitting', 'Moving',
            'Delivery', 'Pet Care', 'IT Support', 'Hair Styling', 'Makeup Artist',
            'Photography', 'Mechanic', 'Fitness Training', 'Cooking', 'Driving'
        ];

        foreach (range(1, 20) as $i) {
            $user = User::create([
                'first_name' => "Provider $i",
                'last_name' => "ln $i",
                'date_of_birth' => now(),
                'email' => "provider$i@example.com",
                'password' => Hash::make('password'),
                'is_provider' => true,
                'hourly_rate' => rand(20, 100),
                'years_of_experience' => rand(1, 15),
                'location' => rand(10000, 99999),
            ]);

            // Attach 1-3 random services
            $services = collect($serviceNames)->random(rand(1, 3));
            foreach ($services as $name) {
                $service = Service::firstOrCreate(['name' => $name]);
                $user->services()->attach($service->id);
            }
        }
    }
}
