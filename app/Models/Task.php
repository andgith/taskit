<?php

namespace App\Models;

use App\Events\TaskCompleted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
            'pinned' => 'boolean'
        ];
    }

    /**
     * Get the user that the task belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toggleComplete(): bool
    {
        $this->completed_at = $this->completed_at ? null : now();
        $this->save();

        if ($this->completed_at) {
            TaskCompleted::dispatch($this);
        }

        return true;
    }

    public function togglePinned(): bool
    {
        $this->pinned = ! $this->pinned;
        $this->save();

        return true;
    }
}
