<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        if ($users->count() < 2) {
            return; // Need at least 2 users to create testimonials
        }

        $testimonialTemplates = [
            ['content' => 'Excellent service! Very professional and reliable.', 'rating' => 5],
            ['content' => 'Great experience working with this provider. Highly recommended!', 'rating' => 5],
            ['content' => 'Good work quality and on time delivery.', 'rating' => 4],
            ['content' => 'Professional service, will hire again.', 'rating' => 4],
            ['content' => 'Satisfied with the work done.', 'rating' => 3],
        ];

        foreach ($users as $user) {
            $otherUsers = $users->where('id', '!=', $user->id);
            
            // Create 1-3 testimonials for each user
            $testimonialCount = rand(1, min(3, $otherUsers->count()));
            $selectedAuthors = $otherUsers->random($testimonialCount);
            
            foreach ($selectedAuthors as $author) {
                $template = $testimonialTemplates[array_rand($testimonialTemplates)];
                
                Testimonial::create([
                    'user_id' => $user->id,
                    'author_id' => $author->id,
                    'content' => $template['content'],
                    'rating' => $template['rating'],
                ]);
            }
        }
    }
}