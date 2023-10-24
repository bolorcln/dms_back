<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReportPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'action_type',
        'action',
        'for',
        'user_id',
        'group_id',

        'manual_data_upload_flag',
        'data_source_url',
        'report_upload_type_id',
        'allow_manual_data_upload'
    ];

    public function parameters(): HasMany
    {
        return $this->hasMany(ReportPermissionParameter::class);
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
