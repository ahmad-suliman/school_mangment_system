<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassessRequest;
use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.Classes.index', ['classes' => Classes::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassessRequest $request)
    {

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
        return view('Admin.Classes.edit', compact('classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClassessRequest $request, string $id)
    {

        Classes::findorfail($id)->update($request->validated());
        return redirect()->back()->with('success', 'class edit successfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $classes = Classes::findorfail($id)->delete();
       return redirect()->back()->with('danger', 'class deleted successfuly');
    }
}
