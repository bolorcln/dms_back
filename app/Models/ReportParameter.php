<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'type',
        'value_type',
        'value'
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
