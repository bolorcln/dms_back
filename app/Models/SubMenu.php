<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'order',
        'parent_id'
    ];

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => 'T' . Str::padLeft($attributes['id'], 3, '0')
        );
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
