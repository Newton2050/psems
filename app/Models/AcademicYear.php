<?php
namespace App\Models;

use App\Core\Model;

/**
 * Class AcademicYear
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string|null $start_date
 * @property string|null $end_date
 * @property \DateTimeInterface|null $created_at
 * @property \DateTimeInterface|null $updated_at
 */
class AcademicYear extends Model
{
    // Only needed if your base Model cannot infer the table name automatically
    protected string $table = 'academic_years';

    // Mass-assignable attributes (adjust to match your schema)
    protected array $fillable = [
        'name',
        'start_date',
        'end_date',
    ];

    // Cast date-like fields to DateTime (or string/int as appropriate)
    protected array $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // If your model doesn't use created_at/updated_at timestamps:
    // public $timestamps = false;

    // Example relationship: an academic year has many enrollments (adjust naming)
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'academic_year_id');
    }
}
