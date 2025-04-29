<?php 
require "functions/transactions.php";

if(!isset($_SESSION["id"])) header("Location:login.php");

if(isset($_GET["id"]) && filter_var($_GET["id"], FILTER_VALIDATE_INT)){
    $transaction=get_transaction($_GET["id"]);
    $categories=get_categories($transaction["category_id"]);
    $_SESSION["form_data"] = [
        "id"=>$_GET["id"],
        "type" => $categories["type"],
        "name_type" => $categories["nom"],
        "montant" => $transaction["montant"],
        "description" => $transaction["description"],
        "date_transaction" => $transaction["date_transaction"]
    ];

    header("Location: add_edit_tran.php");
}


$year= isset($_GET['year'])? $_GET['year'] : "";
$month = isset($_GET['month'])? $_GET['month'] : "";
$transactions=get_transactions($year,$month);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>transactions</title>
    <style>
        :root {
            --bg-color: #F2EFE7;
            --primary: #9ACBD0;
            --secondary: #48A6A7;
            --accent: #006A71;
        }
        body{
            background-color: #F2EFE7;
            position: relative;
        }
        button{
            cursor: pointer;
        }
        .filter {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            align-items: center;
        }
        .filter label {
            color: var(--accent);
            font-weight: bold;
        }
        .filter input, .filter select, .filter button {
            padding: 8px 12px;
            border: 1px solid var(--secondary);
            border-radius: 4px;
            background-color: white;
            color: var(--accent);
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .filter input:focus, .filter select:focus, .filter button:hover {
            border-color: var(--accent);
            outline: none;
        }
        .filter button {
            background-color: var(--accent);
            color: white;
            border: none;
            cursor: pointer;
        }

        #ajouter{
        background-color: transparent;border: none;cursor: pointer;
        position: fixed;
        bottom: 75px;
        right: 75px;
        }
        #ajouter img{
            box-sizing: border-box;
            width: 40px;
            transition: transform 0.3s;
            border-radius: 50%;
        }
        #ajouter:hover img{
            border:2px solid #00fbff;
            transform: rotate(90deg);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: var(--accent);
            color: white;
        }
        td  button{
            padding: 8px 12px;
            border: 1px solid var(--secondary);
            border-radius: 4px;
            background-color: white;
            color: var(--accent);
            font-size: 16px;
            transition: background-color 0.3s;
        }
        td  a:first-of-type button{
            margin-right: 1em;
        }
        td  a:first-of-type button:hover{
            background-color: rgb(179, 74, 74);
        }
        td  a:last-of-type button:hover{
            background-color:rgb(8, 78, 8);
            color: wheat;
        }
        tr:hover {
            background-color: var(--primary);
        }
    </style>
</head>
<body>
    <header>

    </header>
    <main>
        <h2>filter</h2>
        <div class="filter">
            <form method="get">
                <label for="year">Year:</label>
                <input type="number" name="year" id="year" min="1999" max="<?php echo date('Y'); ?>" value="<?php echo isset($_GET['year']) ? htmlspecialchars($_GET['year']) : ''; ?>" placeholder="e.g., 1999">
                <label for="month">Month:</label>
                <select name="month" id="month">
                    <option value="">All</option>
                    <?php
                    for ($i = 1; $i <= 12; $i++):
                        $date = new DateTime("2024-$i-01");
                        $monthName = $date->format('F');
                    ?>
                        <option value="<?php echo $i; ?>" <?php if(isset($_GET['month']) && $_GET['month'] == $i) echo 'selected'; ?>><?php echo $monthName; ?></option>
                    <?php endfor; ?>
                </select>
                <button type="submit">Filter</button>
                <button type="reset">Rest</button>
            </form>
        </div>
        <h2>Transactions</h2>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($transactions as $transaction): ?>
                <tr>
                    <td><?= $transaction["type"] ?></td>
                    <td><?= $transaction["montant"] ?></td>
                    <td><?= $transaction["description"] ?></td>
                    <td><?= $transaction["date_transaction"] ?></td>
                    <td><a href="transactions.php?rm=<?=$transaction['id']?>"><button>remove</button></a> <a href="transactions.php?id=<?=$transaction['id']?>"><button>update</button></a></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <button id="ajouter"  title="Click to ajouter"  onclick="window.location.href='add_edit_tran.php'"><img src="img/plus.png" alt=""></button>
    </main>
    <footer></footer>
</body>
</html>