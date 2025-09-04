<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\OutgoingLetter
 *
 * @property int $id
 * @property string $letter_number
 * @property string $recipient
 * @property string $subject
 * @property \Illuminate\Support\Carbon $letter_date
 * @property string $priority
 * @property string $status
 * @property string $content
 * @property string|null $file_path
 * @property string|null $notes
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\LetterArchive|null $archive
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingLetter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingLetter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingLetter query()
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingLetter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingLetter whereLetterNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingLetter whereRecipient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingLetter whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OutgoingLetter whereStatus($value)
 * @method static \Database\Factories\OutgoingLetterFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class OutgoingLetter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'letter_number',
        'recipient',
        'subject',
        'letter_date',
        'priority',
        'status',
        'content',
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
     * Get the archive record for this letter.
     */
    public function archive(): HasOne
    {
        return $this->hasOne(LetterArchive::class, 'letter_id')->where('letter_type', 'outgoing');
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