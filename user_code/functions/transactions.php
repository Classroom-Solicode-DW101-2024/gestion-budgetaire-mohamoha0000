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

    $sql .= " ORDER BY trans.date_transaction DESC LIMIT 30";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>