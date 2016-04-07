<?php
require_once "conf.php";
require_once "db.php";

class Auth
{
    public function __construct()
    {
        die('Init function is not allowed');
    }

    private static function hashWithSalt($plainAuthCode)
    {
        return hash('sha512', Conf::$salt . $plainAuthCode);
    }

    public static function addSecret($plainAuthCode)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("insert into auth values(?)");
        return $stmt->execute(array(Auth::hashWithSalt($plainAuthCode)));
    }

    public static function isValidSecret($plainAuthCode)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("select * from auth where SECRET=(?)");
        $ret = $stmt->execute(array(Auth::hashWithSalt($plainAuthCode)));
        if (!$ret) {
            // ERROR!
            return false;
        }
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$res) return false;
        return count($res) == 1;
    }
}