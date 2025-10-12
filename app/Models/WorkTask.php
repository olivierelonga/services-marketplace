<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkTask extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'client_name',
        'client_contact',
        'client_email',
        'address',
        'access_instructions',
        'materials_needed',
        'tools_required',
        'measurements',
        'photos',
        'estimated_cost',
        'actual_cost',
        'estimated_hours',
        'actual_hours',
        'work_completed',
        'notes',
        'client_approved',
        'date_completed',
        'assigned_to',
        'follow_up_needed',
        'safety_notes',
        'warranty_notes',
    ];
}
