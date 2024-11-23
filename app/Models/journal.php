<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional if it's plural of the model name)
    protected $table = 'journals';

    // Specify which fields are mass assignable
    protected $fillable = [
        'title',
        'author',
        'category',
        'publication_date',
        'description',
        'is_accessible',
    ];

    // Add the default value for 'is_accessible' in the database schema (use an enum or boolean field)
    const ACCESSIBLE_REQUESTED = 'requested';
    const ACCESSIBLE_GRANTED = 'granted';
    const ACCESSIBLE_DENIED = 'denied';

    // You can use accessor to work with the 'is_accessible' state more easily
    public function getIsAccessibleAttribute($value)
    {
        return ucfirst($value); // Capitalizes the status value (requested, granted, denied)
    }

    // Optionally define relations, e.g., Journal could belong to a Category or have a User requesting access
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
