<?php
namespace App\Models;

use App\Core\Model;

/**
 * Class Setting
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \DateTimeInterface|null $created_at
 * @property \DateTimeInterface|null $updated_at
 */
class Setting extends Model
{
    protected string $table = 'settings';

    protected array $fillable = [
        'key',
        'value',
    ];

    protected array $casts = [
        // store JSON or other structured settings if needed
        'value' => 'string',
    ];
}
