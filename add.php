<?php
require_once "db.php";
require_once "conf.php";
require_once "auth.php";
include "partials/header.php";

// Note that auth code is sent in the clear without HTTPS!
if (empty($_POST)) {
    echo "
    <p class='title'>Add</p>
    <form action='" . $_SERVER['PHP_SELF'] . "' method='post' accept-charset='utf-8'>
        <div class='control'>
                <input class='input' type='text' name='short' placeholder='short url, e.g. me'>
</div>
<div class='control'>
                <input class='input' type='text' name='url' placeholder='long url, e.g. http://my.cool.website'>
</div>
                                <div class='control'>
                <input class='input' type='password' name='secret' placeholder='authorization code'>
</div>
                <div class='control'>
            <button class='button is-medium is-primary' type='submit'>
                Add
            </button>
        </div>
    </form>";
} else {
    if (empty($_POST["secret"]) || !Auth::isValidSecret($_POST["secret"])) {
        die ("Not authorized.");
    }
    if (empty($_POST["short"]) || empty($_POST["url"])) {
        die("No url to add");
    }

    try {
        //open the database
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $short = $_POST["short"];
        $Url = $_POST["url"];
        $q = $pdo->prepare("Insert into redirect (short, url) values(?,?)");
        $ret = $q->execute(array($short, $Url));
        Database::disconnect();
        $shortUrl = (Conf::$httpsEnabled ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . '/' . Conf::getBase() .'/' . $short;
        echo "Done! </br> <a href='$shortUrl'>$shortUrl</a>";
        // close the database connection
    } catch (PDOException $e) {
        print 'Exception : ' . $e->getMessage();
    }
}
include "partials/footer.php";

?>