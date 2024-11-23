<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newspaper extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional if it's plural of the model name)
    protected $table = 'newspapers';

    // Specify which fields are mass assignable
    protected $fillable = [
        'title',
        'publisher',
        'publication_date',
        'status', // 'available' or 'stored'
    ];

    // Optionally add any status constants to make it easier to handle different newspaper statuses
    const STATUS_AVAILABLE = 'available';
    const STATUS_STORED = 'stored';

    // You can use accessor to show status in a user-friendly format (Optional)
    public function getStatusAttribute($value)
    {
        return ucfirst($value); // Capitalizes 'available' or 'stored' status
    }

}
