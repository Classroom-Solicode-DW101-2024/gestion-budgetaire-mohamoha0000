<?php 
require "functions/dashboard.php";
require "functions/user.php";

if(isset($_GET["logout"])){
    session_destroy();
    header("Location:login.php");
}

if(!isset($_SESSION["id"])) header("Location:login.php");
$transactions=getplusgrand();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <style>
        :root {
            --bg-color: #F2EFE7;
            --primary: #9ACBD0;
            --secondary: #48A6A7;
            --accent: #006A71;
        }
        body{
            background-color: #F2EFE7;
        }
        hr{
            margin: 1em auto 1em;
            border: 2px solid #006A71;
            width: 80%;
            border-radius: 10px;
        }
        h1{
            color:#006A71;
        }
        .name_user{
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        table {
            width: 100%;
            max-width: 800px;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 20px auto 20px;
            border-radius: 5px;
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

        tr:hover {
            background-color: var(--primary);
        }
    </style>
</head>
<body>
    <div id="header-container"></div>
    <main>
        <h1>
            <span>Welcome</span>
            <span class="name_user"><?= name_user($_SESSION["id"]) ?></span>
        </h1>
        <hr>
        <h1 style="margin-left: 1em;color: #48A6A7;">Le solde actuel:</h1>
        <h1 style="text-align: center;"><?= solde_actuel()."DH" ?></h1>
        <hr>
        <h1 style="margin-left: 1em;color: #48A6A7;">Résumé du mois en cours : total des revenus / dépenses:</h1>
        <h1 style="margin-left: 2em"><?= "1.total des revenus: ".revenus_depenses()["total_revenus"]."DH" ?></h1>
        <h1 style="margin-left: 2em"><?= "2.total des dépenses: ".revenus_depenses()["total_depenses"]."DH" ?></h1>
        <hr>
        <h1 style="margin-left: 1em;color: #48A6A7;">le plus grand du mois en cours:</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($transactions as $transaction): ?>
                <tr>
                    <td><?= $transaction["categorie"] ?></td>
                    <td><?= $transaction["type"] ?></td>
                    <td><?= $transaction["montant"] ?></td>
                    <td><?= $transaction["description"] ?></td>
                    <td><?= $transaction["date_transaction"] ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </main>
    <footer></footer>

    <script>
    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
    fetch("header.html?v="+getRandomInt(0, 1000))
        .then(res => res.text())
        .then(data => {
        document.getElementById("header-container").innerHTML = data;

        const navMenu = document.querySelector("header nav ul");
        const hamburgerIcon = document.querySelector(".hamburger");
        const links = document.querySelectorAll("header nav ul li a");

        links.forEach(a => {
            a.addEventListener("click", () => {
            navMenu.classList.remove('show');
            });
        });

        hamburgerIcon.addEventListener("click", () => {
            navMenu.classList.toggle("show");
        });
        })
        .catch(err => console.error("Failed to load header:", err));
    </script>

</body>
</html>