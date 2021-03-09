<?php

try {
    $dbh = new PDO("mysql:host=127.0.0.1; dbname=test; charset=utf8", 'username', 'password');

    $sql = 'CREATE TABLE user (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(20),
        age INT(11),
        registry_default DATETIME
    ) engine=innodb default charset=utf8';

    $res = $dbh->query($sql);

} catch(PDDException $e) {
    echo $e->getMessage();
    die();
}
$dbh = null;

?>