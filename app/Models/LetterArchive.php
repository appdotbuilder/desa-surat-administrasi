<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\LetterArchive
 *
 * @property int $id
 * @property string $letter_type
 * @property int $letter_id
 * @property string $archive_number
 * @property string $category
 * @property string|null $archive_notes
 * @property int $archived_by
 * @property \Illuminate\Support\Carbon $archived_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $archivedBy
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|LetterArchive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterArchive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterArchive query()
 * @method static \Illuminate\Database\Eloquent\Builder|LetterArchive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterArchive whereLetterType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterArchive whereArchiveNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LetterArchive whereCategory($value)
 * @method static \Database\Factories\LetterArchiveFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class LetterArchive extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'letter_type',
        'letter_id',
        'archive_number',
        'category',
        'archive_notes',
        'archived_by',
        'archived_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'archived_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who archived this letter.
     */
    public function archivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'archived_by');
    }

    /**
     * Get the letter (incoming or outgoing) that this archive belongs to.
     */
    public function letter()
    {
        if ($this->letter_type === 'incoming') {
            return $this->belongsTo(IncomingLetter::class, 'letter_id');
        }
        
        return $this->belongsTo(OutgoingLetter::class, 'letter_id');
    }

    /**
     * Scope a query to only include incoming letter archives.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncoming($query)
    {
        return $query->where('letter_type', 'incoming');
    }

    /**
     * Scope a query to only include outgoing letter archives.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOutgoing($query)
    {
        return $query->where('letter_type', 'outgoing');
    }
}