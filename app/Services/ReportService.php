<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportParameter;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ReportService
{
  public function create(array $input): Report
  {
    DB::beginTransaction();
    try {
      $report = Report::create(array_merge(
        Arr::except($input, ['parameters']),
        [
          'data_source_url' => $input['manual_data_upload_flag'] ? $input['data_source_url'] : null,
          'report_upload_type_id' => $input['manual_data_upload_flag'] ? $input['report_upload_type_id'] : null
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
      $report->update(array_merge(
        Arr::except($input, ['parameters']),
        [
          'data_source_url' => $input['manual_data_upload_flag'] ? $input['data_source_url'] : null,
          'report_upload_type_id' => $input['manual_data_upload_flag'] ? $input['report_upload_type_id'] : null
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
}