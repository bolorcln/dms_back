<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPermissionParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'type',
        'value_type',
        'value'
    ];
}
