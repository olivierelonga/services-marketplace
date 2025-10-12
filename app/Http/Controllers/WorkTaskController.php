<?php

namespace App\Http\Controllers;

use App\Models\WorkTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('work-tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'client_name' => 'nullable|string|max:255',
            'client_contact' => 'nullable|string|max:255',
            'client_email' => 'nullable|email',
            'address' => 'nullable|string',
            'access_instructions' => 'nullable|string',
            'materials_needed' => 'nullable|string',
            'tools_required' => 'nullable|string',
            'measurements' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:10240',
            'estimated_cost' => 'nullable|numeric',
            'estimated_hours' => 'nullable|numeric',
            'safety_notes' => 'nullable|string',
            'warranty_notes' => 'nullable|string',
        ]);

        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('work_tasks', 'public');
                $photoPaths[] = $path;
            }
        }

        $workTask = new WorkTask($validated);
        $workTask->photos = json_encode($photoPaths);
        $workTask->assigned_to = auth()->id();
        $workTask->save();

        return redirect()->route('provider.dashboard')->with('success', 'Work task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkTask $workTask)
    {
        return view('work-tasks.show', compact('workTask'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkTask $workTask)
    {
        return view('work-tasks.edit', compact('workTask'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkTask $workTask)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed',
            'client_name' => 'nullable|string|max:255',
            'client_contact' => 'nullable|string|max:255',
            'client_email' => 'nullable|email',
            'address' => 'nullable|string',
            'access_instructions' => 'nullable|string',
            'materials_needed' => 'nullable|string',
            'tools_required' => 'nullable|string',
            'measurements' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:10240',
            'estimated_cost' => 'nullable|numeric',
            'actual_cost' => 'nullable|numeric',
            'estimated_hours' => 'nullable|numeric',
            'actual_hours' => 'nullable|numeric',
            'work_completed' => 'nullable|string',
            'notes' => 'nullable|string',
            'client_approved' => 'boolean',
            'date_completed' => 'nullable|date',
            'follow_up_needed' => 'boolean',
            'safety_notes' => 'nullable|string',
            'warranty_notes' => 'nullable|string',
        ]);

        $photoPaths = $workTask->photos ? json_decode($workTask->photos, true) : [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('work_tasks', 'public');
                $photoPaths[] = $path;
            }
        }

        $workTask->fill($validated);
        $workTask->photos = json_encode($photoPaths);
        $workTask->save();

        return redirect()->route('provider.dashboard')->with('success', 'Work task updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkTask $workTask)
    {
        // Optional: Add authorization check
        if ($workTask->assigned_to !== auth()->id()) {
            return redirect()->route('provider.dashboard')->with('error', 'You are not authorized to delete this task.');
        }

        // Delete photos from storage
        if ($workTask->photos) {
            foreach (json_decode($workTask->photos) as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $workTask->delete();

        return redirect()->route('provider.dashboard')->with('success', 'Work task deleted successfully.');
    }
}