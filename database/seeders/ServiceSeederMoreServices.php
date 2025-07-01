<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceSeederMoreServices extends Seeder
{
    public function run(): void
    {
        // Define categories and their services
        $data = [
            'Home Improvement' => ['Painting', 'Plumbing', 'Carpentry', 'Electrical Work', 'Tiling', 'Wallpapering'],
            'Cleaning' => ['House Cleaning', 'Window Cleaning', 'Carpet Cleaning', 'Post-construction Cleaning'],
            'Automotive' => ['Mechanic', 'Car Wash', 'Tire Fitting', 'Auto Electrician'],
            'Beauty & Wellness' => ['Hairdressing', 'Barber', 'Massage Therapy', 'Makeup Artist'],
            'Construction' => ['Bricklaying', 'Welding', 'Scaffolding', 'Roofing'],
            'Tech Help' => ['Computer Repair', 'TV Mounting', 'CCTV Installation'],
        ];

        foreach ($data as $categoryName => $services) {
            $category = ServiceCategory::firstOrCreate(['name' => $categoryName]);

            foreach ($services as $serviceName) {
                Service::updateOrCreate(
                    ['name' => $serviceName],
                    ['service_category_id' => $category->id]
                );
            }
        }
    }
}
