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
        }
        return self::$db;
    }
}
