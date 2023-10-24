<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportParameter;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet;

class ReportService
{
  public function __construct(private ExcelFileService $excelFileService)
  {}

  public function create(array $input): Report
  {
    DB::beginTransaction();
    try {
      $newPath = null;
      if (isset($input['example_file_path']) && $input['example_file_path'] != null) {
        $tempPath = $input['example_file_path'];
        $newPath = Str::of($tempPath)
          ->replaceMatches('/^temp\//', 'report_files/');

        Storage::copy($tempPath, $newPath);
        Storage::delete($tempPath);
      }

      $report = Report::create(array_merge(
        Arr::except($input, ['parameters']),
        [
          'data_source_url' => $input['manual_data_upload_flag'] ? $input['data_source_url'] : null,
          'report_upload_type_id' => $input['manual_data_upload_flag'] ? $input['report_upload_type_id'] : null,
          'example_file_path' => $input['manual_data_upload_flag'] ? $newPath : null
        ]
      ));

      $report->parameters()->createMany($input['parameters']);

      DB::commit();
      return $report;
    } catch (Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  public function update(Report $report, array $input): Report
  {
    DB::beginTransaction();
    try {
      $newPath = null;
      if (isset($input['example_file_path']) && $input['example_file_path'] != null) {
        $oldPath = $input['example_file_path'];
        $newPath = $oldPath;
        if (Str::of($oldPath)->isMatch('/^temp\//')) {
          $newPath = Str::of($oldPath)
            ->replaceMatches('/^temp\//', 'report_files/');

          Storage::copy($oldPath, $newPath);
          Storage::delete($oldPath);
        }
      }

      $report->update(array_merge(
        Arr::except($input, ['parameters']),
        [
          'data_source_url' => $input['manual_data_upload_flag'] ? $input['data_source_url'] : null,
          'report_upload_type_id' => $input['manual_data_upload_flag'] ? $input['report_upload_type_id'] : null,
          'example_file_path' => $input['manual_data_upload_flag'] ? $newPath : null
        ]
      ));

      $parameters = collect($input['parameters']);
      $ids = $parameters->filter(fn ($parameter) => isset($parameter['id']))->pluck('id')->toArray();
      $report->parameters()->whereNotIn('id', $ids)->delete();
      $parameters->each(function ($parameter) use ($report) {
        $report->parameters()->updateOrCreate([
          'id' => $parameter['id'] ?? null,
        ], $parameter);
      });

      DB::commit();
      return $report;
    } catch (Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  public function uploadFile($file)
  {
    $path = $file->store('temp');

    // $table = $this->excelFileService->loadTable(Storage::path($path), [
    //   'Нэр' => 'name',
    //   'Төрөл' => 'type',
    //   'Утга төрөл' => 'value_type',
    //   'Утгууд' => 'value'
    // ]);

    // return [
    //   'path' => $path,
    //   'parameters' => $table
    // ];
    return [
      'path' => $path
    ];
  }
}