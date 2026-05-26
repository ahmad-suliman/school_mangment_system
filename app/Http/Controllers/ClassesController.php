<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassessRequest;
use App\Models\Classes;
use Illuminate\Auth\Authenticatable;
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
        $search = $request->search;
        $this->authorize('viewAny',Classes::class);
        $classes = Classes::query()
        ->when($search,function ($query) use ($search){
            $query->where('class_name','like',"%$search%")
            ->orWhere('section','like',"%$search%");
        })
        ->latest()
        ->paginate(10);

        return view('Admin.Classes.index',compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Classes::class);
        return view('Admin.Classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassessRequest $request)
    {
        $this->authorize('create',Classes::class);
        //CHECK IF THE CLASSROOM EXIST IN DB
        $exists = Classes::where('class_name',$request->class_name)->where('section',$request->section)->exists();
        if(!$exists){
        Classes::create($request->validated());
        }else{
            return redirect()->back()->with('danger','classroom alraedy exists');
        }
        return redirect()->route('admin.classes.index')->with('success', 'class add successfuly');
    }

    public function edit(string $id)
    {
        $classes = Classes::findorfail($id);
        $this->authorize('update',$classes);
        return view('Admin.Classes.edit', compact('classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClassessRequest $request, string $id)
    {

        $classes = Classes::findorfail($id)->update($request->validated());
        $this->authorize('update',$classes);
        return redirect()->back()->with('success', 'class edit successfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $classes = Classes::findorfail($id);
       $this->authorize('delete',$classes);
       $classes->delete();
       return redirect()->back()->with('danger', 'class deleted successfuly');
    }
}
