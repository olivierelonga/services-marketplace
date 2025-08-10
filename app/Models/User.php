<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        //'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'password',
        'phone',
        'bio',
        'years_of_experience',
        'location',
        'date_of_birth',
        'gender',
        'role',
        'hourly_rate',
        'is_provider',
        'whatsapp_number',
        'has_whatsapp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    /**
     * Get testimonials written for this user
     */
    public function testimonials()
    {
        return $this->hasMany(Testimonial::class)->withAuthor()->latest();
    }

    /**
     * Get testimonials written by this user
     */
    public function writtenTestimonials()
    {
        return $this->hasMany(Testimonial::class, 'author_id')->with('user')->latest();
    }

    /**
     * Check if this user has written a testimonial for another user
     */
    public function hasWrittenTestimonialFor($userId)
    {
        return $this->writtenTestimonials()->where('user_id', $userId)->exists();
    }

    /**
     * Get average rating from testimonials
     */
    public function getAverageRatingAttribute()
    {
        return $this->testimonials()->avg('rating');
    }

    /**
     * Get total testimonials count
     */
    public function getTotalTestimonialsAttribute()
    {
        return $this->testimonials()->count();
    }
}
