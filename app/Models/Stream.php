<?php
namespace App\Models;

use App\Core\Model;

/**
 * Class Stream
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \DateTimeInterface|null $created_at
 * @property \DateTimeInterface|null $updated_at
 */
class Stream extends Model
{
    protected string $table = 'streams';

    protected array $fillable = [
        'name',
        'description',
    ];

    // Example: a stream has many pupils
    public function pupils()
    {
        return $this->hasMany(Pupil::class, 'stream_id');
    }
}
