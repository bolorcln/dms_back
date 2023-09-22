<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'order'
    ];

    protected function code(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => 'D' . Str::padLeft($attributes['id'], 3, '0')
        );
    }

    public function children()
    {
        return $this->hasMany(SubMenu::class, 'parent_id');
    }
}
