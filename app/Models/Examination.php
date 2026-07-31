<?php
namespace App\Models;

use App\Core\Model;

/**
 * Class Examination
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property \DateTimeInterface|null $date
 * @property int|null $academic_year_id
 * @property string|null $instructions
 * @property \DateTimeInterface|null $created_at
 * @property \DateTimeInterface|null $updated_at
 */
class Examination extends Model
{
    // Only needed if your base Model cannot infer the table name automatically
    protected string $table = 'examinations';

    // Mass-assignable attributes (adjust to match your schema)
    protected array $fillable = [
        'title',
        'date',
        'academic_year_id',
        'instructions',
    ];

    // Cast date-like fields to DateTime (or string/int as appropriate)
    protected array $casts = [
        'date' => 'datetime',
    ];

    // If your model doesn't use created_at/updated_at timestamps:
    // public $timestamps = false;

    // An examination belongs to an academic year
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    // Example relationship: an examination has many questions
    public function questions()
    {
        return $this->hasMany(Question::class, 'examination_id');
    }
}
