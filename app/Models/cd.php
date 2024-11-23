<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cd extends Model
{
    use HasFactory;

    // Specify the table name (optional if the table name is plural of the model)
    protected $table = 'cds';

    // Allow mass assignment for the following attributes
    protected $fillable = [
        'title',
        'author',
        'category',
        'publication_date',
        'description',
        'is_accessible', // Control access based on this field
    ];

    /**
     * Access control for CDs, e.g., only accessible if 'granted'.
     */
    public function isAccessible()
    {
        return $this->is_accessible === 'granted';
    }
}
