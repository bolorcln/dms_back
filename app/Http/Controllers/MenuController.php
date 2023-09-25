<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuListingResource;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize') ?? 5;
        $sortColumn = match ($request->query('sortColumn')) {
            'code' => 'id',
            'name', 'description', 'order' => $request->query('sortColumn'),
            default => 'id'
        };
        $sortDir = match ($request->query('sortDir')) {
            'asc', 'desc' => $request->query('sortDir'),
            default => 'asc'
        };
        $menus = Menu::query()
            ->orderBy($sortColumn, $sortDir)
            ->paginate($pageSize);

        return MenuResource::collection($menus);
    }

    /**
     * List menus by order with sub-menus
     */
    public function listing()
    {
        $menu = Menu::query()
            ->with(['children' => function (Builder $query) {
                $query->orderby('order', 'asc');
            }])
            ->orderBy('order', 'asc')
            ->get();

        return MenuListingResource::collection($menu);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuRequest $request)
    {
        $menu = Menu::create($request->validated());
        return new MenuResource($menu);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return new MenuResource($menu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());
        return new MenuResource($menu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return response()->noContent();
    }
}
