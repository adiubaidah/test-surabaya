<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Http\Controllers\Controller;

class DivisionController extends Controller
{
    public function get(Request $request) {
        $name = $request->query('name');

        // Build the query
        $query = Division::query();

        // If 'name' parameter is provided, filter by name
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        // Paginate the results
        $divisions = $query->paginate(10); // Adjust the number as needed
        return response()->json([
            'status' => 'success',
            'message' => 'Data division berhasil diambil',
            'data' => [
                'divisions' => $divisions->items()
            ],
            'pagination' => [
                'current_page' => $divisions->currentPage(),
                'last_page' => $divisions->lastPage(),
                'per_page' => $divisions->perPage(),
                'total' => $divisions->total(),
                'next_page_url' => $divisions->nextPageUrl(),
                'prev_page_url' => $divisions->previousPageUrl(),
            ]
        ]);
    }
}
