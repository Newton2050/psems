<?php
namespace App\Core;
class Session
{
    private static bool $started = false;
    private static array $flashData = [];
    private static string $flashKey = '_flash';
    
    public static function start(): void
    {
        if (self::$started) return;
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'cookie_lifetime' => (int)($_ENV['SESSION_LIFETIME'] ?? 7200),
                'cookie_path' => '/',
                'cookie_httponly' => true,
                'cookie_samesite' => 'Strict',
                'use_strict_mode' => true,
            ]);
        }
        self::$started = true;
        self::loadFlashData();
    }
    
    public static function set(string $key, $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }
    
    public static function get(string $key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }
    
    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }
    
    public static function remove(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }
    
    public static function flash(string $key, $value = null)
    {
        self::start();
        if ($value === null) {
            $data = self::$flashData[$key] ?? null;
            unset(self::$flashData[$key]);
            return $data;
        }
        self::$flashData[$key] = $value;
        $_SESSION[self::$flashKey] = self::$flashData;
        return null;
    }
    
    public static function getFlash(string $key, $default = null)
    {
        return self::flash($key) ?? $default;
    }
    
    private static function loadFlashData(): void
    {
        if (isset($_SESSION[self::$flashKey])) {
            self::$flashData = $_SESSION[self::$flashKey];
        }
    }
    
    public static function destroy(): void
    {
        self::start();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path']);
        }
        session_destroy();
        self::$started = false;
        self::$flashData = [];
    }
    
    public static function id(): string
    {
        self::start();
        return session_id();
    }
}
