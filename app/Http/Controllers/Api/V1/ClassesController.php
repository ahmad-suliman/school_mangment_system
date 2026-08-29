<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassessRequest;
use App\Http\Resources\ClassesResource;
use App\Models\Classes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Classes::class);
        $search = $request->search;
        $classes = Classes::query()
            ->when($search, function ($query) use ($search) {
                $query->where('class_name', 'like', "%$search%")
                    ->orWhere('section', 'like', "%$search%");
            })
            ->latest()
            ->paginate(10);

        return ClassesResource::collection($classes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassessRequest $request)
    {
        $this->authorize('create', Classes::class);

        $exists = Classes::where('class_name', $request->class_name)
            ->where('section', $request->section)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Classroom already exists'], 422);
        }

        $class = Classes::create($request->validated());

        return response()->json([
            'message' => 'Class added successfully',
            'data'    => new ClassesResource($class),
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClassessRequest $request, string $id)
    {
        $classes = Classes::findOrFail($id);
        $this->authorize('update', $classes);
        $classes->update($request->validated());
        return response()->json([
            'message' => 'Class updated successfully',
            'data'    => new ClassesResource($classes),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classes = Classes::findOrFail($id);
        $this->authorize('delete', $classes);

        $classes->delete();

        return response()->json(['message' => 'Class deleted successfully']);
    }
}
