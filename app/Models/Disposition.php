<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Disposition
 *
 * @property int $id
 * @property int $incoming_letter_id
 * @property int $assigned_to
 * @property int $assigned_by
 * @property string $instructions
 * @property string $priority
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $due_date
 * @property string|null $notes
 * @property string|null $completion_notes
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\IncomingLetter $incomingLetter
 * @property-read \App\Models\User $assignedTo
 * @property-read \App\Models\User $assignedBy
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Disposition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Disposition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Disposition query()
 * @method static \Illuminate\Database\Eloquent\Builder|Disposition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposition whereIncomingLetterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposition whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposition whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposition pending()
 * @method static \Database\Factories\DispositionFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Disposition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'incoming_letter_id',
        'assigned_to',
        'assigned_by',
        'instructions',
        'priority',
        'status',
        'due_date',
        'notes',
        'completion_notes',
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the incoming letter that this disposition belongs to.
     */
    public function incomingLetter(): BelongsTo
    {
        return $this->belongsTo(IncomingLetter::class);
    }

    /**
     * Get the user this disposition is assigned to.
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the user who assigned this disposition.
     */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * Scope a query to only include pending dispositions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include overdue dispositions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', '!=', 'completed')
            ->where('due_date', '<', now());
    }
}