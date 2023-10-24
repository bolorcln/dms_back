<?php

namespace App\Services;

use App\Models\ReportPermission;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ReportPermissionService
{
  public function create(array $input): ReportPermission
  {
    DB::beginTransaction();
    try {
      $reportPermission = ReportPermission::create(array_merge(
        Arr::except($input, ['parameters']),
        [
          'action' => implode(',', $input['action']),
          'user_id' => $input['for'] == 'user' ? $input['user_id'] : null,
          'group_id' => $input['for'] == 'group' ? $input['group_id'] : null,
          'data_source_url' => $input['manual_data_upload_flag'] ? $input['data_source_url'] : null,
          'report_upload_type_id' => $input['manual_data_upload_flag'] ? $input['report_upload_type_id'] : null,
          'allow_manual_data_upload' => $input['manual_data_upload_flag'] ? $input['allow_manaul_data_upload'] : false
        ]
      ));

      $reportPermission->parameters()->createMany($input['parameters']);

      DB::commit();
      return $reportPermission;
    }
    catch (Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  public function update(ReportPermission $reportPermission, array $input): ReportPermission
  {
    DB::beginTransaction();
    try {
      $reportPermission->update(array_merge(
        Arr::except($input, ['parameters']),
        [
          'action' => implode(',', $input['action']),
          'user_id' => $input['for'] == 'user' ? $input['user_id'] : null,
          'group_id' => $input['for'] == 'group' ? $input['group_id'] : null,
          'data_source_url' => $input['manual_data_upload_flag'] ? $input['data_source_url'] : null,
          'report_upload_type_id' => $input['manual_data_upload_flag'] ? $input['report_upload_type_id'] : null,
          'allow_manual_data_upload' => $input['manual_data_upload_flag'] ? $input['allow_manaul_data_upload'] : false
        ]
      ));

      $parameters = collect($input['parameters']);
      $ids = $parameters->filter(fn ($parameter) => isset($parameter['id']))->pluck('id')->toArray();
      $reportPermission->parameters()->whereNotIn('id', $ids)->delete();
      $parameters->each(function ($parameter) use ($reportPermission) {
        $reportPermission->parameters()->updateOrCreate([
          'id' => $parameter['id'] ?? null,
        ], $parameter);
      });

      DB::commit();
      return $reportPermission;
    }
    catch (Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }
}