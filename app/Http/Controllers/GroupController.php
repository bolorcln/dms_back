<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\UserResource;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    public function __construct()
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize') ?? 5;
        $sortColumn = match ($request->query('sortColumn')) {
            'code' => 'id',
            'name', 'description' => $request->query('sortColumn'),
            default => 'id'
        };
        $sortDir = match ($request->query('sortDir')) {
            'asc', 'desc' => $request->query('sortDir'),
            default => 'asc'
        };
        $groups = Group::query()
            ->orderBy($sortColumn, $sortDir)
            ->paginate($pageSize);
        return GroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupRequest $request)
    {
        $group = Group::create($request->validated());
        return new GroupResource($group);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return new GroupResource($group);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GroupRequest $request, Group $group)
    {
        $group->update($request->validated());

        return new GroupResource($group);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return response()->noContent();
    }

    public function users(Request $request, Group $group)
    {
        $pageSize = $request->query('pageSize') ?? 5;
        return UserResource::collection($group->users()->paginate($pageSize));
    }

    public function addUser(Request $request, Group $group)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id', Rule::unique('group_user', 'user_id')->where('group_id', $group->id)] 
        ]);

        $group->users()->attach($validated['user_id']);

        return response()->noContent();
    }

    public function removeUser(Group $group, User $user)
    {
        $group->users()->detach($user);

        return response()->noContent();
    }
}
