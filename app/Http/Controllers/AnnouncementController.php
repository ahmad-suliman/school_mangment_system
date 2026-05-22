<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnouncementRequest;
use App\Models\Announcement;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Notifications\AnonymousNotifiable;

class AnnouncementController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Announcement::class);
        $user = auth()->user();
        //if user admin show all annoucement
        if ($user->hasRole('admin')) {
            $announcements = Announcement::with('user')
                ->latest()
                ->paginate(10);
        }
        if ($user->hasRole('teacher')) {
            $announcements = Announcement::where('target_role', 'teacher')->orWhere('target_role', 'all')->paginate(10);
        }
        return view('Admin.Announcement.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Announcement::class);
        return view('Admin.Announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnnouncementRequest $request)
    {
        $data = $request->validated();
        $announcements = Announcement::create([
            'title' => $data['title'],
            'message' => $data['message'],
            'target_role' => $data['target_role'],
            'user_id' => auth()->id(),
            'published_at' => now(),
        ]);
        if ($data['target_role'] === 'all') {
            $users = User::all();
        } else {
            $users = User::role($data['target_role'])->get();
        }

        foreach ($users as $user) {

            $user->notify(
                new AnnouncementNotification($announcements)
            );
        }
        return redirect()->back()->with('success', 'Announcement created');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $announcement = Announcement::findorfail($id);
        $this->authorize('update',$announcement);
        return view('Admin.Announcement.edit',compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update (StoreAnnouncementRequest $request, string $id)
    {

        $data = $request->validated();
        $announcement = Announcement::findorfail($id);
        $this->authorize('update',$announcement);
        $announcement->update([
            'title' => $data['title'],
            'message' => $data['message'],
            'target_role' => $data['target_role'],
              ]);
             return  redirect()->route('admin.announcements.index')->with('success','Announcement Updaeted');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $announcement = Announcement::findorfail($id);
        $this->authorize('delete',$announcement);
        $announcement->delete();
        return redirect()->back()->with('danger','Announcement Deleted');
    }
}
