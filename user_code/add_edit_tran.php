<?php 
$categories = [
    'revenu' => ['Salaire', 'Bourse', 'Ventes', 'Autres'],
    'depense' => ['Logement', 'Transport', 'Alimentation', 'Santé', 'Divertissement', 'Éducation', 'Autres']
];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><? "edit" ?></title>
    <style>
        body{
            height: 100vh;
            margin: 0;
        }
        main{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            background-color: #F2EFE7;
        }
        main form{
            display: flex;
            flex-direction: column;
            width:100%;
            min-width: 100px;
            max-width: 300px;
            background-color: #9ACBD0;
            padding: 1em;
            border-radius: 30px;
            box-shadow: 10px 10px 5px rgba(0,0,0,0.2);
            gap: 0.5em;
            
        }
        main form input , main form select,main form textarea{
            outline: none;
            padding: 0.5em;
            border-radius: 10px;
            border: 2px solid #ccc;
            transition: border-color 0.3s ease;
        }
        main form input:focus,main form select:focus,main form textarea:focus{
            border-color: #4A90E2;
        }
        main form button{
            padding: 0.5em 1em;
            width:100%;
            max-width: 150px;
            background-color: #48A6A7;
            border-radius: 10px;
            box-shadow: 5px 5px 2px rgba(0,0,0,0.2);
            transition: background-color 0.5s ease,color 0.5s ease;
            border: 1px solid #3d3d3d;
            cursor: pointer;
        }
        main form button:hover{
            background-color: #006A71;
            color: white;
        }
        #togglePassword{
            width: 10%;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        
    </header>
    <main>
        <form method="post">
            <h1 style="text-align: center;"><?= isset($_GET["id"]) ? "update" : "ajouter"; ?></h1>
            <label for="type">type:</label>
            <div>
                <span>revenu</span> <input type="radio" name="type" id="type" value="revenu" onchange="this.form.submit()" <?php if (isset($_POST['type']) && $_POST['type'] === 'revenu') echo 'checked'; ?>>
                <span>depense</span><input type="radio" name="type" id="type" value="depense" onchange="this.form.submit()" <?php if (isset($_POST['type']) && $_POST['type'] === 'depense') echo 'checked'; ?>>
            </div>
            <select name="name_type" id="name_type">
                <option value="" selected disabled>select name type</option>
                <?php foreach($categories[$_POST['type']] as $name):?>
                    <option value="<?=$name;?>" <?php if (isset($_POST['name_type'])) echo $_POST['name_type'] === $name ? 'selected' : '';?>><?=$name;?></option>
                <?php endforeach;?>
            </select>
            <label for="montant">montant:</label>
            <input type="number" step="any" id="montant" name="montant" value="<?= $_POST["montant"] ?>">
            <label for="description">description:</label>
            <textarea name="description" id="description" cols="30" rows="5"><?= $_POST["description"] ?></textarea>
            <button><?= isset($_GET["id"]) ? "update" : "ajouter"; ?></button>
        </form>
    </main>
    <footer></footer>
</body>
</html>