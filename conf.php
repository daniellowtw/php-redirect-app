<?php

class Conf
{
    public static $dbFileName = "redirect.db";
    public static $dbTable = "redirect";
    // With trailing slash!
    public static $salt = "p0w3r";
    // Set to true if you have https set up on your web server.
    public static $httpsEnabled = false;

    public static function getBase()
    {
        return dirname($_SERVER['SCRIPT_NAME']);
    }
}