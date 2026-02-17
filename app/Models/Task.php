<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Builder;
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

    public function getStatusLabelAttribute(): string
    {
        return $this->status?->label() ?? '';
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status?->color() ?? '';
    }

    protected $appends = ['status_label', 'status_color'];

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if ($search) {
            $query->whereRaw('LOWER(title) LIKE ?', ['%'.strtolower($search).'%']);
        }

        return $query;
    }

    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if ($status) {
            $query->where('status', $status);
        }

        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
