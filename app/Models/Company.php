<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sector'];
    protected $hidden = ['created_at', 'updated_at'];
    
    function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'company_id', 'id');
    }
}
