<?php

class UserModel extends AbstractModel
{
    public static $table   = '::users';
    public static $primary = 'user_id';

    public static function selectByEmail($login)
    {
        $sql = self::sql("SELECT * FROM ::table WHERE email = ? LIMIT 1");

        return Database::fetchSingle($sql, [$login]);
    }
}
