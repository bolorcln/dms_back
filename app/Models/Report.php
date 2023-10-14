<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'view_url',
        'sub_menu_id',
        'manual_data_upload_flag',
        'data_source_url',
        'report_upload_type_id',
        'support_phone',
        'support_desktop',
        'support_tablet',
        'hide_tabs',
        'show_toolbar',
        'height',
        'width',
        'is_interactive',
        'is_active'
    ];

    protected $casts = [
        'manual_data_upload_flag' => 'boolean',
        'support_phone' => 'boolean',
        'support_desktop' => 'boolean',
        'support_tablet' => 'boolean',
        'hide_tabs' => 'boolean',
        'show_toolbar' => 'boolean',
        'is_interactive' => 'boolean',
        'is_active' => 'boolean'
    ];

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => 'R' . Str::padLeft($attributes['id'], 3, '0')
        );
    }

    public function subMenu(): BelongsTo
    {
        return $this->belongsTo(SubMenu::class);
    }

    public function parameters(): HasMany
    {
        return $this->hasMany(ReportParameter::class);
    }
}
