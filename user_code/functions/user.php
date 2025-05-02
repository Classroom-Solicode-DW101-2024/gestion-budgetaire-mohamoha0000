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

function login($password,$email){
    global $pdo;
    if(existe_email($email)){
        $sql = "SELECT password,id FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $rusult = $stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($password,$rusult["password"])){
            return $rusult["id"];
        }else{
            return 0;
        }
    }
}

function name_user($id){
    global $pdo;
    $sql = "SELECT prenom,nom FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $rusult = $stmt->fetch(PDO::FETCH_ASSOC);
    return $rusult["prenom"]." ".$rusult["nom"];
}

?>