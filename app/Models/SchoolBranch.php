<?php

namespace App\Models;

use Eloquent;

class SchoolBranch extends Eloquent
{
    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'email',
        'description',
        'is_active',
        'logo'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'school_branch_id');
    }

    public function students()
    {
        return $this->hasMany(StudentRecord::class, 'school_branch_id');
    }
}
