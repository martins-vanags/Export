<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'type',
        'file_path',
        'status',
        'query_count',
        'total_rows',
        'processed_rows',
        'content',
    ];
}
