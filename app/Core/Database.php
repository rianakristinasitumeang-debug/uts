<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

final class Database
{
    private PDO $connection;

    public function __construct()
    {
        $storagePath = APP_ROOT . '/storage';
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0775, true);
        }

        $databasePath = $storagePath . '/rumah-anyam.sqlite';
        $isNewDatabase = !file_exists($databasePath);
        $this->connection = new PDO('sqlite:' . $databasePath, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $this->connection->exec('PRAGMA foreign_keys = ON');

        if ($isNewDatabase) {
            $schema = file_get_contents(APP_ROOT . '/database/schema.sql');
            if ($schema === false) {
                throw new \RuntimeException('Database schema could not be loaded.');
            }
            $this->connection->exec($schema);
        }
    }

    public function connection(): PDO
    {
        return $this->connection;
    }
}
