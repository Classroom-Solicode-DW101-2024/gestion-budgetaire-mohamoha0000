<?php 
require "config.php";
function existe_email($email){
    global $pdo;
    $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $count = $stmt->fetchColumn();
    return $count > 0;
}
function register($nom,$prenom,$email,$password){
    global $pdo;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql="INSERT INTO users (nom,prenom,email,password) VALUES (:nom,:prenom,:email,:password)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        'nom'      => $nom,
        'prenom'   => $prenom,
        'email'    => $email,
        'password' => $hashedPassword
    ]);
    return true;
}
?>