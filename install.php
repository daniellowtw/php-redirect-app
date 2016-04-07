<?php
error_reporting(E_ALL);

require_once "conf.php";
if (file_exists(Conf::$dbFileName)) {
    die("Db exists");
}

if (empty($_POST)) {
    include "partials/header.php";
    echo "    <p class='title'>Install</p>
<form action='" . $_SERVER['PHP_SELF'] . "' method='post' accept-charset='utf-8'>
                <div class='control is-grouped'>
                <input class='input' type='password' name='secret' placeholder='authorization code'>
            <button class='button is-primary' type='submit'>
                Install
            </button>
  	</form>";
    include "partials/footer.php";
} else {

    if (empty($_POST["secret"])) {
        die ("Missing secret hash.");
    }

    require_once "db.php";
    require_once "auth.php";

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        $sql = "CREATE TABLE " . Conf::$dbTable . "(
			ID INTEGER PRIMARY KEY AUTOINCREMENT,
	  		SHORT           TEXT    NOT NULL,
	  		URL         VARCHAR     NOT NULL)";
        $pdo->exec($sql);
        $sql = "CREATE TABLE auth (SECRET      TEXT    NOT NULL)";
        $pdo->exec($sql);
        Auth::addSecret($_POST['secret']);
        echo "Done!";
    } catch (PDOException $e) {
        print 'Exception : ' . $e->getMessage();
    } finally {
        Database::disconnect();
    }

}
