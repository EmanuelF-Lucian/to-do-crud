<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_date',
        'status',
    ];

    protected $casts = [
        'due_date' => 'datetime:Y-m-d',
        'status' => TaskStatus::class,
    ];

    protected $appends = ['status_label'];

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
