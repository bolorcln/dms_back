<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportPermissionRequest;
use App\Http\Resources\ReportPermissionResource;
use App\Models\ReportPermission;
use App\Services\ReportPermissionService;
use Illuminate\Http\Request;

class ReportPermissionController extends Controller
{
    public function __construct(private ReportPermissionService $service)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize') ?? 5;
        $permissions = ReportPermission::query()
            ->with(['parameters', 'report', 'user', 'group'])
            ->paginate($pageSize);

        return ReportPermissionResource::collection($permissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportPermissionRequest $request)
    {
        $validatedData = $request->validated();
        $permission = $this->service->create($validatedData);
        $permission->load(['parameters', 'report', 'user', 'group']);
        return new ReportPermissionResource($permission);
    }

    /**
     * Display the specified resource.
     */
    public function show(ReportPermission $reportPermission)
    {
        $reportPermission->load(['parameters', 'report', 'user', 'group']);
        return new ReportPermissionResource($reportPermission);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreReportPermissionRequest $request, ReportPermission $reportPermission)
    {
        $validatedData = $request->validated();
        $reportPermission = $this->service->update($reportPermission, $validatedData);
        $reportPermission->load(['parameters', 'report', 'user', 'group']);
        return new ReportPermissionResource($reportPermission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReportPermission $reportPermission)
    {
        $reportPermission->delete();
        return response()->noContent();
    }
}
