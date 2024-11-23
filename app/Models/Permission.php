<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends SpatiePermission
{
    use HasFactory;

    protected $fillable = ['name', 'category']; // Only add category to the fillable attributes

    /**
     * Get the category of the permission.
     */
    public function getCategoryAttribute()
    {
        return $this->attributes['category'] ?? 'General';
    }

    // No additional methods needed unless you want to add custom logic
}
