<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuPermissionRequest;
use App\Http\Resources\MenuPermissionResource;
use App\Models\MenuPermission;
use Illuminate\Http\Request;

class MenuPermissionController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize') ?? 5;
        $sortColumn = match ($request->query('sortColumn')) {
            // 'code' => 'id',
            // 'name', 'description', 'order' => $request->query('sortColumn'),
            default => 'id'
        };
        $sortDir = match ($request->query('sortDir')) {
            'asc', 'desc' => $request->query('sortDir'),
            default => 'asc'
        };
        $permissions = MenuPermission::query()
            ->with(['menu'])
            ->orderBy($sortColumn, $sortDir)
            ->paginate($pageSize);
        return MenuPermissionResource::collection($permissions);
    }

    public function store(StoreMenuPermissionRequest $request)
    {
        $validated = $request->validated();
        $permission = MenuPermission::create(array_merge(
            $validated,
            [
                'action' => implode(',', $validated['action']),
                'user_id' => $validated['for'] == 'user' ? $validated['user_id'] : null,
                'group_id' => $validated['for'] == 'group' ? $validated['group_id'] : null
            ]
        ));
        return new MenuPermissionResource($permission);
    }

    public function show(MenuPermission $permission)
    {
        return new MenuPermissionResource($permission);
    }

    public function update(StoreMenuPermissionRequest $request, MenuPermission $permission)
    {
        $validated = $request->validated();
        $permission->update(array_merge(
            $validated,
            [
                'action' => implode(',', $validated['action']),
                'user_id' => $validated['for'] == 'user' ? $validated['user_id'] : null,
                'group_id' => $validated['for'] == 'group' ? $validated['group_id'] : null
            ]
        ));
        return new MenuPermissionResource($permission);
    }

    public function destroy(MenuPermission $permission)
    {
        $permission->delete();
        return response()->noContent();
    }
}
