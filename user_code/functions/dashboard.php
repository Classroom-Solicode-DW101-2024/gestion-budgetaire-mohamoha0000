<?php 
require "config.php";

function solde_actuel(){
    global $pdo;
    $sql="SELECT 
    u.id AS user_id,
    u.nom AS user_name,
    COALESCE(SUM(CASE WHEN c.type = 'revenu' THEN t.montant ELSE 0 END), 0) -
    COALESCE(SUM(CASE WHEN c.type = 'depense' THEN t.montant ELSE 0 END), 0) AS solde_actuel
    FROM users u
    LEFT JOIN transactions t ON u.id = t.user_id
    LEFT JOIN categories c ON t.category_id = c.id
    WHERE u.id = {$_SESSION['id']}
    GROUP BY u.id;
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['solde_actuel'] ?? 0;

}

function revenus_depenses(){
    global $pdo;
    $sql="SELECT 
    COALESCE(SUM(CASE WHEN c.type = 'revenu' THEN t.montant ELSE 0 END), 0) AS total_revenus,
    COALESCE(SUM(CASE WHEN c.type = 'depense' THEN t.montant ELSE 0 END), 0) AS total_depenses
    FROM transactions t
    JOIN categories c ON t.category_id = c.id
    WHERE t.user_id = {$_SESSION['id']}
    AND MONTH(t.date_transaction) = MONTH(CURRENT_DATE())
    AND YEAR(t.date_transaction) = YEAR(CURRENT_DATE());
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function get_max($type){
    global $pdo;
    $sql="SELECT MAX(t2.montant) FROM transactions t2 
    JOIN categories c2 ON t2.category_id = c2.id
    WHERE t2.user_id = {$_SESSION['id']}
    AND c2.type = '$type'
    AND MONTH(t2.date_transaction) = MONTH(CURRENT_DATE())
    AND YEAR(t2.date_transaction) = YEAR(CURRENT_DATE())";
    return $pdo->query($sql)->fetchColumn();
}

function getplusgrand(){
    global $pdo;
  
    $max_depense = get_max('depense');
    $max_revenu = get_max('revenu');

    if ($max_depense === null && $max_revenu === null) {
        return [];
    }

    $sql="SELECT 
    t.id,
    c.type,
    c.nom AS categorie,
    t.montant,
    t.description,
    t.date_transaction
    FROM transactions t
    JOIN categories c ON t.category_id = c.id
    WHERE t.user_id = {$_SESSION['id']}
    AND MONTH(t.date_transaction) = MONTH(CURRENT_DATE())
    AND YEAR(t.date_transaction) = YEAR(CURRENT_DATE())
    AND (
        (c.type = 'depense' AND t.montant = $max_depense)
        OR
        (c.type = 'revenu' AND t.montant = $max_revenu)
    )";
    
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}


?>