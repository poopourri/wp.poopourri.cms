<?

// we want the database for saving orders and fetching fixed addresses
define('DB_NAME','wp_poopourri');
define('DB_USER','poopourri');
define('DB_PASSWORD','2hFAiCWFFVMz239d6zvC');
define('DB_HOST','127.0.0.1');
define('DB_HOST_SLAVE','localhost');

$link = mysql_connect(DB_HOST_SLAVE, DB_USER, DB_PASSWORD);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
//mysql_close($link);

mysql_select_db(DB_NAME, $link);

?>