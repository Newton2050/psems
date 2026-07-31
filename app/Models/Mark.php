<?php
namespace App\Models;

use App\Core\Model;

/**
 * Class Mark
 *
 * @package App\Models
 *
 * @property int $id
 * @property float|int|null $score
 * @property int|null $pupil_id
 * @property int|null $subject_id
 * @property int|null $term_id
 * @property int|null $examination_id
 * @property \DateTimeInterface|null $created_at
 * @property \DateTimeInterface|null $updated_at
 */
class Mark extends Model
{
    protected string $table = 'marks';

    protected array $fillable = [
        'score',
        'pupil_id',
        'subject_id',
        'term_id',
        'examination_id',
    ];

    protected array $casts = [
        'score' => 'float',
    ];

    // public $timestamps = true;

    public function pupil()
    {
        return $this->belongsTo(Pupil::class, 'pupil_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function examination()
    {
        return $this->belongsTo(Examination::class, 'examination_id');
    }
}
