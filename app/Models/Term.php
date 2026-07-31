<?php
namespace App\Models;

use App\Core\Model;

/**
 * Class Term
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property \DateTimeInterface|null $start_date
 * @property \DateTimeInterface|null $end_date
 * @property int|null $academic_year_id
 * @property \DateTimeInterface|null $created_at
 * @property \DateTimeInterface|null $updated_at
 */
class Term extends Model
{
    protected string $table = 'terms';

    protected array $fillable = [
        'name',
        'start_date',
        'end_date',
        'academic_year_id',
    ];

    protected array $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
}
