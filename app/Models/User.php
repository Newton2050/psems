<?php
namespace App\Models;

use App\Core\Model;

/**
 * Class User
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $password
 * @property string|null $role
 * @property \DateTimeInterface|null $created_at
 * @property \DateTimeInterface|null $updated_at
 */
class User extends Model
{
    protected string $table = 'users';

    protected array $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected array $casts = [
        // no default casts, add as needed
    ];

    // Example: a user may be a teacher or administrator
    // Add relationships as appropriate for your application
}
