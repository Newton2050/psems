<?php
namespace App\Models;

use App\Core\Model;

/**
 * Class Grade
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property float|int|null $value
 * @property int|null $student_id
 * @property int|null $examination_id
 * @property string|null $remarks
 * @property \DateTimeInterface|null $created_at
 * @property \DateTimeInterface|null $updated_at
 */
class Grade extends Model
{
    // Only needed if your base Model cannot infer the table name automatically
    protected string $table = 'grades';

    // Mass-assignable attributes (adjust to match your schema)
    protected array $fillable = [
        'name',
        'value',
        'student_id',
        'examination_id',
        'remarks',
    ];

    // Cast numeric fields appropriately
    protected array $casts = [
        'value' => 'float',
    ];

    // If your model doesn't use created_at/updated_at timestamps:
    // public $timestamps = false;

    // Example relationship: a grade belongs to a student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Example relationship: a grade belongs to an examination
    public function examination()
    {
        return $this->belongsTo(Examination::class, 'examination_id');
    }
}
