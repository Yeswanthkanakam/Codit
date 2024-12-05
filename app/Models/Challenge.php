<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'difficulty', 'category_id', 'content'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'challenge_user')
            ->withPivot('completed_at')
            ->withTimestamps();
    }

    public function solutions()
    {
        return $this->hasMany(Solution::class);
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

}
