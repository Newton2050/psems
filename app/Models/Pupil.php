<?php
namespace App\Models;

use App\Core\Model;

/**
 * Class Pupil
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string|null $admission_no
 * @property \DateTimeInterface|null $date_of_birth
 * @property string|null $gender
 * @property int|null $stream_id
 * @property \DateTimeInterface|null $created_at
 * @property \DateTimeInterface|null $updated_at
 */
class Pupil extends Model
{
    protected string $table = 'pupils';

    protected array $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'admission_no',
        'date_of_birth',
        'gender',
        'stream_id',
    ];

    protected array $casts = [
        'date_of_birth' => 'datetime',
    ];

    public function stream()
    {
        return $this->belongsTo(Stream::class, 'stream_id');
    }

    // Example: a pupil has many marks
    public function marks()
    {
        return $this->hasMany(Mark::class, 'pupil_id');
    }
}
