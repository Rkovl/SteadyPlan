<?php

class BaseRepo {
    static private $db = null;

    /**
     * @return mixed
     */
    protected static function getDB()
    {
        if (self::$db === null) {
            self::$db = Database::getInstance()->getConnection();

            if (self::$db === null) {
                throw new Exception("Database connection failed. Please check your database configuration and ensure the database server is running.");
            }
        }
        return self::$db;
    }
}
