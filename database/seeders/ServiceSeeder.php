<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $services = ['Plumbing', 'Painting', 'Electrical', 'Carpentry', 'Gardening'];
        foreach ($services as $name) {
            Service::create(['name' => $name]);
        }
    }
}
