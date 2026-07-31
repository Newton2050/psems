<?php
namespace App\Models;

use App\Core\Model;

/**
 * Class Teacher
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string|null $email
 * @property \DateTimeInterface|null $created_at
 * @property \DateTimeInterface|null $updated_at
 */
class Teacher extends Model
{
    protected string $table = 'teachers';

    protected array $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }
}
