<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'action_type',
        'action',
        'for',
        'user_id',
        'group_id'
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
