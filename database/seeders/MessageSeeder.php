<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Message;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Ensure there's a user to assign messages to
        $user = User::first() ?? User::factory()->create();

        foreach (range(1, 20) as $i) {
            Message::create([
                // 'name' => $faker->name,
                // 'email' => $faker->safeEmail,
                // 'phone' => $faker->phoneNumber,
                'body' => $faker->realText(150),
                'receiver_id' => $user->id,
            ]);
        }
    }
}
