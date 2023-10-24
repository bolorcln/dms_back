<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet;

class ReportController extends Controller
{
    public function __construct(private ReportService $service)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->query('pageSize') ?? 5;
        $reports = Report::query()
            ->with(['subMenu', 'parameters'])
            ->paginate($pageSize);

        return ReportResource::collection($reports);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReportRequest $request)
    {
        $validated = $request->validated();
        $report = $this->service->create($validated);
        return new ReportResource($report);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return new ReportResource($report);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReportRequest $request, Report $report)
    {
        $validated = $request->validated();
        $report = $this->service->update($report, $validated);
        return new ReportResource($report);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return response()->noContent();
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        $result = $this->service->uploadFile($file);
        // if (isset($result['error'])) {
        //     return response()->json([
        //         'error' => $result['error']
        //     ], 422);
        // }

        return response()->json($result);
    }
}
