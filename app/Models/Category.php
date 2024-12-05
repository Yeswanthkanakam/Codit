<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the challenges for the category.
     */
    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }
}
