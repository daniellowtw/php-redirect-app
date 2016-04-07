<?php
include "partials/header.php";
require_once "conf.php";
require_once "auth.php";

if (empty($_POST)) {
    echo "    <p class='title'>Delete</p>
    <form action='" . $_SERVER['PHP_SELF'] . "' method='post' accept-charset='utf-8'>
  		<div class='control'>
                <input class='input' type='text' name='short' placeholder='short url, e.g. me'>
</div>
 <div class='control'>
                <input class='input' type='password' name='secret' placeholder='authorization code'>
</div>
                <div class='control'>
            <button class='button is-medium is-primary' type='submit'>
                Delete
            </button>
  	</form>";
} else {
    try {
        if (empty($_POST["secret"]) || !Auth::isValidSecret($_POST["secret"])) {
            die ("Not authorized.");
        }
        if (empty($_POST["short"])) {
            die("No url to delete");
        }
        $shortUrl = $_POST["short"];
        require_once "db.php";
        $pdo = Database::connect();
        $stmt = $pdo->prepare("Delete from " . Conf::$dbTable . " where short = ?");
        $ret = $stmt->execute(array($shortUrl));
        Database::disconnect();
        if ($ret) {
            echo "Done!";
        }
        include "partials/footer.php";
    } catch (PDOException $e) {
        print 'Exception : ' . $e->getMessage();
    }
}
?>