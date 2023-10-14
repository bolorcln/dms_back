<?php

namespace App\Http\Controllers;

use App\Models\TableauServerConfig;
use Illuminate\Http\Request;

class TableauServerConfigController extends Controller
{
  public function index()
  {
    $config = TableauServerConfig::first();
    return response()->json($config);
  }

  public function store(Request $request)
  {
    $config = TableauServerConfig::first();
    if ($config == null) {
      $config = TableauServerConfig::create($request->all());
    } else {
      $config->update($request->all());
    }
    return response()->json($config);
  }
}