<?php
namespace App\Core;
class Auth
{
    private static ?array $user = null;
    private const SESSION_KEY = 'auth_user';
    
    public static function login(array $user, bool $remember = false): bool
    {
        Session::start();
        Session::set(self::SESSION_KEY, [
            'id' => $user['id'],
            'email' => $user['email'] ?? $user['username'] ?? '',
            'role' => $user['role'] ?? 'user',
            'name' => $user['name'] ?? $user['full_name'] ?? 'User'
        ]);
        self::$user = null;
        return true;
    }
    
    public static function check(): bool
    {
        Session::start();
        return Session::has(self::SESSION_KEY);
    }
    
    public static function user(): ?array
    {
        Session::start();
        if (!self::check()) return null;
        if (self::$user === null) {
            self::$user = Session::get(self::SESSION_KEY);
        }
        return self::$user;
    }
    
    public static function id(): ?int
    {
        $user = self::user();
        return $user ? (int)$user['id'] : null;
    }
    
    public static function role(): ?string
    {
        $user = self::user();
        return $user ? $user['role'] : null;
    }
    
    public static function hasRole(string $role): bool
    {
        $user = self::user();
        return $user && strtolower($user['role']) === strtolower($role);
    }
    
    public static function hasAnyRole(array $roles): bool
    {
        $user = self::user();
        if (!$user) return false;
        return in_array(strtolower($user['role']), array_map('strtolower', $roles));
    }
    
    public static function logout(): void
    {
        Session::start();
        Session::remove(self::SESSION_KEY);
        Session::destroy();
        self::$user = null;
    }
}
