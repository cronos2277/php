<?php
require_once(dirname(__FILE__,2).'/src/config/config.php');
require_once(dirname(__FILE__,2).'/src/models/User.php');
$sql = "select * from users";
$result = Database::getResultFromQuery($sql);
while($row = $result->fetch_assoc()){
    print_r($row);
    echo "<br>";
}

$user = new User(['name' => 'nome', 'email' => 'email@email']);
print_r($user);
