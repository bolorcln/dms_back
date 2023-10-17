<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet;

class ExcelFileService
{
  public function loadTable($filePath, $tableColumns)
  {
    $spreadSheet = PhpSpreadSheet\IOFactory::load($filePath);
    $workSheet = $spreadSheet->getActiveSheet();
    $higestRowAndColumn = $workSheet->getHighestRowAndColumn();
    $row = $higestRowAndColumn['row'];
    $column = PhpSpreadSheet\Cell\Coordinate::columnIndexFromString($higestRowAndColumn['column']);

    $columns = collect()->range(1, $column)
      ->reduce(
        callback: function ($acc, $col) use ($workSheet, $tableColumns) {
          $cellValue = $workSheet->getCell([$col, 1])->getValue();
          if (isset($tableColumns[$cellValue])) {
            $acc[$tableColumns[$cellValue]] = $col;
          } 
          return $acc;
        },
        initial: []
      );

    $table = [];
    for ($r = 2; $r <= $row; $r++) {
      $tableRow = [];
      for ($col = 1; $col <= $column; $col++) {
        $columnName = array_search($col, $columns);
        if ($columnName == false) {
          continue;
        }
        $value = $workSheet->getCell([$col, $r])->getValue();
        $tableRow[$columnName] = $value;
      }
      $table[] = $tableRow;
    }

    return $table;
  }
}
