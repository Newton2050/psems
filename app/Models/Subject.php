<?php
namespace App\Models;

use App\Core\Model;

/**
 * Class Subject
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property int|null $teacher_id
 * @property \DateTimeInterface|null $created_at
 * @property \DateTimeInterface|null $updated_at
 */
class Subject extends Model
{
    protected string $table = 'subjects';

    protected array $fillable = [
        'name',
        'code',
        'teacher_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'subject_id');
    }
}
