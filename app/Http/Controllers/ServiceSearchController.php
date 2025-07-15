<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\User;

class ServiceSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');

        $services = Service::with('category') // assuming there's a category relationship
            ->where('name', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json($services);
    }


    // public function suggest(Request $request)
    // {
    //     $query = $request->get('q');

    //     $services = Service::with('category')
    //         ->where('name', 'like', '%' . $query . '%')
    //         ->take(10)
    //         ->get()
    //         ->map(function ($service) {
    //             return [
    //                 'id' => $service->id,
    //                 'name' => $service->name,
    //                 'category_id' => $service->service_category_id,
    //                 'category_name' => optional($service->category)->name,
    //             ];
    //         });

    //     return response()->json($services);
    // }

    public function index(Request $request)
    {
        $query = $request->input('q');
        $rate = $request->input('hourly_rate');
        $experience = $request->input('experience');
        $postal = $request->input('postal_code');

        $providers = User::where('is_provider', true)
            ->when($query, function ($q) use ($query) {
                $q->whereHas('services', function ($s) use ($query) {
                    $s->where('name', 'like', '%' . $query . '%');
                });
            })
            ->when($rate, fn($q) => $q->where('hourly_rate', '<=', $rate))
            ->when($experience, fn($q) => $q->where('years_of_experience', '>=', $experience))
            ->when($postal, fn($q) => $q->where('postal_code', $postal))
            ->with('services')
            ->get();

        return view('search.results', compact('providers'));
    }

}
