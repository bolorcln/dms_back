<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubMenuRequest;
use App\Http\Resources\SubMenuResource;
use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SubMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize') ?? 5;
        $sortColumn = match ($request->query('sortColumn')) {
            'id', 'name', 'description', 'order', 'parent' => $request->query('sortColumn'),
            default => 'id'
        };
        $sortDir = match ($request->query('sortDir')) {
            'asc', 'desc' => $request->query('sortDir'),
            default => 'asc'
        };

        $subMenus = SubMenu::query()
            ->with(['parent'])
            ->when($sortColumn == 'parent', function (Builder $query) use ($sortDir) {
                $query->orderBy(Menu::select('name')->whereColumn('menus.id', 'sub_menus.parent_id'), $sortDir);
            }, function (Builder $query) use ($sortDir, $sortColumn) {
                $query->orderBy($sortColumn, $sortDir);
            })
            ->paginate($pageSize);

        return SubMenuResource::collection($subMenus);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubMenuRequest $request)
    {
        $subMenu = SubMenu::create($request->validated());
        $subMenu->load('parent');
        return new SubMenuResource($subMenu);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubMenu $subMenu)
    {
        $subMenu->load('parent');
        return new SubMenuResource($subMenu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubMenuRequest $request, SubMenu $subMenu)
    {
        $subMenu->update($request->validated());
        $subMenu->load('parent');
        return new SubMenuResource($subMenu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubMenu $subMenu)
    {
        $subMenu->delete();
        return response()->noContent();
    }
}
