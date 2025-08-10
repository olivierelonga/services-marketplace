<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TestimonialController extends Controller
{
    /**
     * Store a newly created testimonial
     */
    public function store(Request $request, User $user): RedirectResponse
    {
        #check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to add a testimonial.');
        }

        #check if user is trying to write testimonial for themselves
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot write a testimonial for yourself.');
        }

        #validate the request
        $validated = $request->validate([
            'rating' => ['required','integer','min:1','max:5'],
            'content' => ['required','string', 'min:3','max:1000']
        ], [
            'rating.required' => 'Please select a rating.',
            'rating.min' => 'Rating must be at least 1 star.',
            'rating.max' => 'Rating cannot exceed 5 stars.',
            'content.required' => 'Please write your testimonial.',
            'content.min' => 'Testimonial must be at least 3 characters long.',
            'content.max' => 'Testimonial cannot exceed 1000 characters.'
        ]);

        try {
            #create the testimonial
            Testimonial::create([
                'user_id' => $user->id,
                'author_id' => Auth::id(),
                'content' => $validated['content'],
                'rating' => $validated['rating']
            ]);

            return redirect()->back()->with('success', 'Your testimonial has been added successfully!');

        } catch (\Illuminate\Database\QueryException $e) {
            // Handle duplicate testimonial (unique constraint violation)
            if ($e->getCode() === '23000') {
                return redirect()->back()->with('error', 'You have already written a testimonial for this user.')->withInput();
            }
            
            // Handle other database errors
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    /**
     * Update an existing testimonial
     */
    public function update(Request $request, User $user, Testimonial $testimonial): RedirectResponse
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if the authenticated user is the author of this testimonial
        if (Auth::id() !== $testimonial->author_id) {
            return redirect()->back()
                ->with('error', 'You can only edit your own testimonials.');
        }

        // Validate the request
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'content' => ['required','string','min:10','max:1000']
        ]);

        try {
            $testimonial->update($validated);

            return redirect()->back()
                ->with('success', 'Your testimonial has been updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove a testimonial
     */
    public function destroy(User $user, Testimonial $testimonial): RedirectResponse
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if the authenticated user is the author of this testimonial or an admin
        if (Auth::id() !== $testimonial->author_id && !Auth::user()->isAdmin()) {
            return redirect()->back()
                ->with('error', 'You can only delete your own testimonials.');
        }

        try {
            $testimonial->delete();

            return redirect()->back()
                ->with('success', 'Testimonial has been deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Show all testimonials for a user (API endpoint)
     */
    public function index(User $user)
    {
        $testimonials = $user->testimonials()->paginate(10);
        
        return response()->json([
            'testimonials' => $testimonials,
            'average_rating' => $user->average_rating,
            'total_testimonials' => $user->total_testimonials,
            'rating_distribution' => Testimonial::ratingDistributionFor($user->id)
        ]);
    }
}