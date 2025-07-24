<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    public function index(Request $request)
    {
        $query = $request->input('q');
        $rate = $request->input('hourly_rate');
        $experience = $request->input('experience');
        $postal = $request->input('postal_code');

        $sql = "
            SELECT 
                users.id,
                users.first_name,
                users.hourly_rate,
                users.years_of_experience,
                users.location,
                GROUP_CONCAT(services.name ORDER BY services.name SEPARATOR ', ') AS services
            FROM 
                users
            JOIN 
                service_user ON service_user.user_id = users.id
            JOIN 
                services ON services.id = service_user.service_id
            WHERE 
                users.is_provider = 1
                AND users.id IN (
                    SELECT su.user_id
                    FROM service_user su
                    JOIN services s ON s.id = su.service_id
                    WHERE s.name LIKE CONCAT('%', :query, '%')
                )
                AND (:rate1 IS NULL OR users.hourly_rate >= :rate2)
                AND (:experience1 IS NULL OR users.years_of_experience >= :experience2)
                AND (:postal1 IS NULL OR users.location = :postal2)
            GROUP BY 
                users.id, users.first_name, users.hourly_rate, users.years_of_experience, users.location
            ORDER BY 
                users.first_name ASC
        ";



        $bindings = [
            'query' => $query,
            'rate1' => $rate,
            'rate2' => $rate,
            'experience1' => $experience,
            'experience2' => $experience,
            'postal1' => $postal,
            'postal2' => $postal,
        ];


        $providers = DB::select($sql, $bindings);

        return view('search.results', compact('providers'));
    }
}
