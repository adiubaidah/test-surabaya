<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request) {
        // Retrieve query parameters
        $name = $request->query('name');
        $division_id = $request->query('division_id');
    
        // Build the query
        $query = Employee::query();
    
        // If 'name' parameter is provided, filter by name
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
    
        // If 'division_id' parameter is provided, filter by division_id
        if ($division_id) {
            $query->where('division_id', $division_id);
        }
    
        // Eager load the division relationship
        $query->with('division');

        $query->orderBy('updated_at', 'desc');
    
        // Paginate the results
        $employees = $query->paginate(10); // Adjust the number as needed
    
        // Transform the data
        $transformedEmployees = $employees->items(); // Get the collection of employees
    
        $transformedEmployees = collect($transformedEmployees)->map(function ($employee) {
            return [
                'id' => $employee->id,
                'image' => str_starts_with($employee->image, 'employee_images') ? url('storage/' . $employee->image) : $employee->image,
                'name' => $employee->name,
                'phone' => $employee->phone,
                'division' => [
                    'id' => $employee->division->id,
                    'name' => $employee->division->name,
                ],
                'position' => $employee->position,
            ];
        });
    
        // Format the response
        return response()->json([
            'status' => 'success',
            'message' => 'Data employee berhasil diambil',
            'data' => [
                'employees' => $transformedEmployees
            ],
            'pagination' => [
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'per_page' => $employees->perPage(),
                'total' => $employees->total(),
                'next_page_url' => $employees->nextPageUrl(),
                'prev_page_url' => $employees->previousPageUrl(),
            ]
        ]);
    }

    public function store(Request $request) {

        // Validate the request
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'phone' => 'required|string',
            'division_id' => 'required|exists:divisions,id',
            'position' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'Data yang dimasukkan tidak valid',
                'errors' => $validator->errors(),
            ], 400);
        }

        $validatedData = $validator->validated();

        //upload image
        $image = $request->file('image');
        $imagePath = $image->store('employee_images', 'public');



        $employee = new Employee;
        $employee->name= $validatedData['name'];
        $employee->phone = $validatedData['phone'];
        $employee->division_id = $validatedData['division_id'];
        $employee->position = $validatedData['position'];
        $employee->image = $imagePath;
        $employee->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Employee berhasil ditambahkan',
        ], 201);
    }

    public function update(Request $request, string $id) {
        dd($request->all());
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'phone' => 'string',
            'division_id' => 'exists:divisions,id',
            'position' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data yang dimasukkan tidak valid',
                'errors' => $validator->errors(),
            ], 400);
        }
    
        $employee = Employee::find($id);
    
        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee tidak ditemukan',
            ], 404);
        }
    
        $validatedData = $validator->validated();
        // dd($validatedData);
    
        // Update the employee
        if (isset($validatedData['name'])) {
            $employee->name = $validatedData['name'];
        }
    
        if (isset($validatedData['phone'])) {
            $employee->phone = $validatedData['phone'];
        }
    
        if (isset($validatedData['division_id'])) {
            $employee->division_id = $validatedData['division_id'];
        }
    
        if (isset($validatedData['position'])) {
            $employee->position = $validatedData['position'];
        }
    
        if (isset($validatedData['image'])) {
            // Delete the old image
            Storage::disk('public')->delete($employee->image);
    
            // Upload the new image
            $image = $request->file('image');
            $imagePath = $image->store('employee_images', 'public');
            $employee->image = $imagePath;
        }
    
        $employee->save();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Employee berhasil diupdate',
        ]);
    }

    public function destroy($id) {
        $employee = Employee::find($id);
    
        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee tidak ditemukan',
            ], 404);
        }
    
        // Delete the image
        Storage::disk('public')->delete($employee->image);
    
        // Delete the employee
        $employee->delete();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Employee berhasil dihapus',
        ]);
    }
    
}