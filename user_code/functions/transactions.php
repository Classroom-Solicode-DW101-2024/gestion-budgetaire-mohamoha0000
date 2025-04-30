<?php 
require "config.php";
function get_transactions($year="",$month=""){
    global $pdo;
    $sql="SELECT trans.*,c.type
      FROM transactions AS trans INNER JOIN categories as c ON c.id = trans.category_id";
    $params = [];
    $conditions = [];
    if (!empty($year)) {
        $conditions[] = "YEAR(trans.date_transaction) = :year";
        $params[':year'] = $year;
    }else{
        $conditions[] = "YEAR(trans.date_transaction) = :year";
        $params[':year'] = date("Y");
    }

    if (!empty($month)) {
        $conditions[] = "MONTH(trans.date_transaction) = :month";
        $params[':month'] = $month;
    }

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }
    $sql .=" AND trans.user_id = :user_id";
    $params['user_id']=$_SESSION["id"];
    $sql .= " ORDER BY trans.date_transaction DESC LIMIT 30";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_transaction($id){
    global $pdo;
    $sql="SELECT * FROM  transactions WHERE id = :id AND user_id = :user_id";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([
         ":id"=>$id,
         ":user_id"=>$_SESSION["id"]
        ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_categories($id){
    global $pdo;
    $sql="SELECT * FROM categories WHERE id = :id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(":id",$id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_id_categories($type,$name_type){
    global $pdo;
    $sql="SELECT id FROM categories WHERE type = :type AND nom = :nom";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(":type",$type);
    $stmt->bindParam(":nom",$name_type);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function get_errors($data){
    $errors=[];
    if(!$data["type"]=="revenu" && !$data["type"]=="depense"){
        $errors["type"]="Veuillez sélectionner un type";
    }
    if(empty($data["name_type"])){
        $errors["name_type"]="Veuillez choisir quelque chose";
    }
    if(!is_numeric($data["montant"])){
        $errors["montant"]="montant n'est pas valide";
    }
    if(empty($data["description"])){
        $errors["description"]="description  est vide";
    }
    $date = $data["date_transaction"];
    $valid = DateTime::createFromFormat('Y-m-d', $date);
    if(!$valid){
        $errors["date_transaction"]="date n'est pas valide";
    }

    return $errors;
}

function _update($data){
    global $pdo;
    $category_id=get_id_categories($data["type"],$data["name_type"]);
    $sql="UPDATE transactions SET category_id  = :category_id, montant=:montant , description=:description ,date_transaction = :date_transaction  WHERE id = :id";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([
        ":category_id"=>$category_id,
        ":montant"=>$data["montant"],
        ":description"=>$data["description"],
        ":date_transaction"=>$data["date_transaction"],
        ":id"=>$data["id"]
    ]);
}
function _ajouter($data){
    global $pdo;
    $category_id=get_id_categories($data["type"],$data["name_type"]);
    $sql="INSERT INTO transactions (user_id,category_id,montant,description,date_transaction) VALUE (?,?,?,?,?)";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([
        $_SESSION["id"],
        $category_id,
        $data["montant"],
        $data["description"],
        $data["date_transaction"]
    ]);
}

function _remove($id){
    global $pdo;
    $sql="DELETE FROM transactions WHERE id=:id AND user_id = :user_id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(":id",$id);
    $stmt->bindParam(":user_id",$_SESSION["id"]);
    $stmt->execute();
}
?>