<?php 
require "config.php";
function existe_email($email){
    global $pdo;
    $sql = "SELECT count(*) FROM users WHERE email = '$email'";
    $stmt = $pdo->prepare($sql);
    if ($stmt->fetch()> 0) {
        return true;
    }else{
        return false;
    }
}
?>