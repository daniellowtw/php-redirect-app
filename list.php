<?php
require_once "db.php";
require_once "conf.php";
require_once "auth.php";
include "partials/header.php";
if (empty($_POST)) {
    echo "
    <p class='title'>View</p>
   <form action='" . $_SERVER['PHP_SELF'] . "' method='post' accept-charset='utf-8'>
        <div class='control'>
                                <div class='control is-grouped'>
                <input class='input' type='password' name='secret' placeholder='authorization code'>
            <button class='button is-primary' type='submit'>
                View
            </button>
        </div>
    </form>";
} else {
    if (empty($_POST["secret"]) || !Auth::isValidSecret($_POST["secret"])) {
        die ("Not authorized.");
    }
    try {
        //open the database
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $ret = $pdo->query("select * from " . Conf::$dbTable);
        if ($ret) {
            echo "
            <table class='table'>
  <thead>
    <tr>
      <th>id</th>
      <th>short</th>
      <th>url</th>
    </tr>
  </thead>
  <tbody>
            ";
            foreach ($ret as $row) {
                echo "    <tr>
      <td>" . $row['ID'] . "</td>
      <td>" . $row['SHORT'] . "</td>
      <td>" . $row['URL'] . "</td>
    </tr>";
            }
        }

        echo "  </tbody>
</table>";
        Database::disconnect();
        // close the database connection
    } catch (PDOException $e) {
        print 'Exception : ' . $e->getMessage();
    }
}
include "partials/footer.php";

?>