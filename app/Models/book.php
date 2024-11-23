<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'author',
        'category',
        'is_physical',   
        'access_code_required', 
        'access_code',
        'available',   
    ];

    /**
     * Get the formatted type of the book.
     *
     * @return string
     */
    public function getTypeAttribute()
    {
        return $this->is_physical ? 'Physical Book' : 'E-Book';
    }

    /**
     * Check if the book is accessible.
     *
     * @return string
     */
    public function isAccessible()
    {
        if ($this->is_physical) {
            return $this->available ? 'Available for borrowing' : 'Currently unavailable';
        }

        return $this->access_code_required
            ? 'Access code required from librarian'
            : 'Accessible on university’s LAN network';
    }
}
