<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicProgram extends Model
{
    use HasFactory;

    protected $table = 'academic_programs';

    protected $fillable = [
        'code',
        'name',
        'college_name',
        'degree_title',
        'total_profs',
        'profs_list',
        'council_type',
        'council_placeholder',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'profs_list'  => 'array',
        'total_profs' => 'integer',
        'sort_order'  => 'integer',
        'is_active'   => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc');
    }
}

