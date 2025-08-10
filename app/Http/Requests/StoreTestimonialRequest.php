<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTestimonialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // User must be authenticated and not writing testimonial for themselves
        return Auth::check() && Auth::id() !== $this->route('user')->id;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5'
            ],
            'content' => [
                'required',
                'string',
                'min:10',
                'max:1000'
            ]
        ];
    }

    /**
     * Get custom error messages
     */
    public function messages(): array
    {
        return [
            'rating.required' => 'Please select a rating.',
            'rating.min' => 'Rating must be at least 1 star.',
            'rating.max' => 'Rating cannot exceed 5 stars.',
            'content.required' => 'Please write your testimonial.',
            'content.min' => 'Testimonial must be at least 10 characters long.',
            'content.max' => 'Testimonial cannot exceed 1000 characters.'
        ];
    }
}
