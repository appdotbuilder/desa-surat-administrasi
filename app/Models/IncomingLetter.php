<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\IncomingLetter
 *
 * @property int $id
 * @property string $letter_number
 * @property string $sender
 * @property string $subject
 * @property \Illuminate\Support\Carbon $letter_date
 * @property \Illuminate\Support\Carbon $received_date
 * @property string $priority
 * @property string $status
 * @property string|null $description
 * @property string|null $file_path
 * @property string|null $notes
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Disposition> $dispositions
 * @property-read \App\Models\LetterArchive|null $archive
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingLetter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingLetter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingLetter query()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingLetter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingLetter whereLetterNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingLetter whereSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingLetter whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingLetter whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IncomingLetter active()
 * @method static \Database\Factories\IncomingLetterFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class IncomingLetter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'letter_number',
        'sender',
        'subject',
        'letter_date',
        'received_date',
        'priority',
        'status',
        'description',
        'file_path',
        'notes',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'letter_date' => 'date',
        'received_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who created this letter.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the dispositions for this letter.
     */
    public function dispositions(): HasMany
    {
        return $this->hasMany(Disposition::class);
    }

    /**
     * Get the archive record for this letter.
     */
    public function archive(): HasOne
    {
        return $this->hasOne(LetterArchive::class, 'letter_id')->where('letter_type', 'incoming');
    }

    /**
     * Scope a query to only include letters with specific status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include letters with specific priority.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $priority
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }
}