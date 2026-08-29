<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Announcement::class);

        $user = auth()->user();
        $search = $request->search;

        if ($user->hasRole('admin')) {
            $announcements = Announcement::query()
                ->when($search, function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(10);

        } else {
            // covers teacher, student, and anyone else — filtered by target_role/all
            $announcements = Announcement::where(function ($query) use ($user) {
                    $query->where('target_role', $user->getRoleNames()->first())
                        ->orWhere('target_role', 'all');
                })
                ->when($search, function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(10);
        }

        return AnnouncementResource::collection($announcements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnnouncementRequest $request)
    {
   $this->authorize('create', Announcement::class);

        $data = $request->validated();

        $announcement = Announcement::create([
            'title'        => $data['title'],
            'message'      => $data['message'],
            'target_role'  => $data['target_role'],
            'user_id'      => auth()->id(),
            'published_at' => now(),
        ]);

        $users = $data['target_role'] === 'all'
            ? User::all()
            : User::role($data['target_role'])->get();

        foreach ($users as $user) {
            $user->notify(new AnnouncementNotification($announcement));
        }

        return response()->json([
            'message' => 'Announcement created successfully',
            'data'    => new AnnouncementResource($announcement),
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAnnouncementRequest $request, string $id)
    {
 $announcement = Announcement::findOrFail($id);
        $this->authorize('update', $announcement);

        $data = $request->validated();

        $announcement->update([
            'title'       => $data['title'],
            'message'     => $data['message'],
            'target_role' => $data['target_role'],
        ]);

        return response()->json([
            'message' => 'Announcement updated successfully',
            'data'    => new AnnouncementResource($announcement),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $announcement = Announcement::findOrFail($id);
        $this->authorize('delete', $announcement);

        $announcement->delete();

        return response()->json(['message' => 'Announcement deleted successfully']);
    }
}
