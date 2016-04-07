<?php
$uris = explode('/', $_SERVER['REQUEST_URI']);
$target = $uris[count($uris) - 1];
if ($target == "") {
    include "partials/header.php";
    echo 'Move along. Nothing to see here.';
    include "partials/footer.php";
    exit();
}
require_once "db.php";
require_once "conf.php";
$pdo = Database::connect();
$sql = "SELECT * FROM " . Conf::$dbTable . " where short = '$target'";
$result = $pdo->query($sql);
Database::disconnect();

if (!$result || (count($result) == 0)) {
    include "partials/header.php";
    echo('Not found. Move along.');
    include "partials/footer.php";
    exit();
}
foreach ($result as $row) {
    // Not sure if needed
    if (!headers_sent()) {
        header("Location: " . $row['URL']);
        exit;
    } else {
        echo "<script type=\"text/javascript\">\n";
        echo "window.location.href=\"" . $row['URL'] . "\";\n";
        echo "</script>\n";
        echo "<noscript>\n";
        echo "<meta http-equiv=\"refresh\" content=\"0;url=" . $row['URL'] . "\" />\n";
        echo "</noscript>\n";
        exit;
    }
}