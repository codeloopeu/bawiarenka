<?php declare(strict_types = 1);

class DatabaseHelper {

    public static function createDatabaseConnectionOrDie() {
        if (!function_exists('pg_connect')) {
            self::dieWithServiceUnavailable('[DatabaseHelper] PHP pgsql extension is not enabled');
        }

        $db_conf = parse_ini_file(__DIR__ . '/.user.ini');
        if ($db_conf === false) {
            self::dieWithServiceUnavailable('[DatabaseHelper] Cannot read ' . __DIR__ . '/.user.ini');
        }

        $host = $db_conf['datasource.host'];
        $dbname = $db_conf['datasource.dbname'];
        $port = $db_conf['datasource.port'];
        $user = $db_conf['datasource.user'];
        $password = $db_conf['datasource.password'];

        $connection = @pg_connect("host=$host dbname=$dbname port=$port user=$user password=$password");
        if ($connection === false) {
            self::dieWithServiceUnavailable("[DatabaseHelper] Cannot connect to database [host=$host, port=$port, user=$user]: " . (error_get_last()['message'] ?? 'unknown error'));
        }
        return $connection;
    }

    public static function insert(string $table, array $values) {
        $connection = self::createDatabaseConnectionOrDie();
        pg_insert($connection, $table, $values);
        pg_close($connection);
    }

    private static function dieWithServiceUnavailable(string $message) {
        error_log($message);
        header('HTTP/1.1 503 Service Unavailable');
        die();
    }
}
