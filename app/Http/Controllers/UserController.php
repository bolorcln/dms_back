<?php

namespace App\Http\Controllers;

use App\Enum\UserStatusEnum;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\UserResource;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize') ?? 5;
        $sortColumn = match ($request->query('sortColumn')) {
            'id', 'name', 'username', 'organisation', 'position' => $request->query('sortColumn'),
            default => 'id'
        };
        $sortDir = match ($request->query('sortDir')) {
            'asc', 'desc' => $request->query('sortDir'),
            default => 'asc'
        };
        $users =  User::query()
            ->orderBy($sortColumn, $sortDir)
            ->paginate($pageSize);

        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create(array_merge(
            $request->validated(),
            [
                'password' => Str::password(),
                'status' => UserStatusEnum::INACTIVE
            ]
        ));

        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(StoreUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return new UserResource($user);
    }

    public function changePassword(ChangePasswordRequest $request, User $user)
    {
        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return new UserResource($user);
    }

    public function changeStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'status' => Rule::enum(UserStatusEnum::class)
        ]);

        $user->update($validated);
        return new UserResource($user);
    }

    public function groups(Request $request, User $user)
    {
        $pageSize = $request->query('pageSize') ?? 5;
        return GroupResource::collection($user->groups()->paginate($pageSize));
    }

    public function addGroup(Request $request, User $user)
    {
        $validated = $request->validate([
            'group_id' => [
                'required',
                'exists:groups,id',
                Rule::unique('group_user', 'group_id')->where('user_id', $user->id)
            ]
        ]);
        $user->groups()->attach($validated['group_id']);

        return response()->noContent();
    }

    public function removeGroup(User $user, Group $group)
    {
        $user->groups()->detach($group);

        return response()->noContent();
    }
}
