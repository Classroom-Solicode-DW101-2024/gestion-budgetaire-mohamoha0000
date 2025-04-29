<?php 
require "functions/user.php";
$erreurs=[];
$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
if (isset($_POST['submit'])) {
    if (!empty($nom)&&!empty($prenom)&&filter_var($email, FILTER_VALIDATE_EMAIL)&&!existe_email($email)&&!empty($password)) {
        if(register($nom,$prenom,$email,$password)){
            header("Location: login.php?email={$email}");
        }
    }else{
        if(empty($nom)){
            $erreurs["nom"] = "Le nom est vide";
        }
        if(empty($prenom)){
            $erreurs["prenom"] = "Le prénom est vide";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $erreurs["email"] = "L'email n'est pas valide";
        }
        if(existe_email($email)){
            $erreurs["email"] = "L'email est déjà utilisé";
        }
        if(empty($password)){
            $erreurs["password"] = "Le mot de passe est vide";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <style>
        body{
            height: 100vh;
            margin: 0;
            background-color: #F2EFE7;
        }
        main{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
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
        main form input{
            outline: none;
            padding: 0.5em;
            border-radius: 10px;
            border: 2px solid #ccc;
            transition: border-color 0.3s ease;
        }
        main form input:focus {
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
        @media (max-height: 600px) {
            main {
                align-items: flex-start;
                padding-top: 1em;
            }
        }
    </style>
</head>
<body>
    <header>

    </header>
    <main>
        <form method="post">
            <h2 style="text-align: center;color: rgb(54, 50, 50);">Register</h2>
            <label for="prenom">prenom:</label>
            <input id="prenom" name="prenom" type="text" value="<?= $prenom ?>" placeholder="enter prenom ...">
            <span style="color: red;"><?php if(isset($erreurs["prenom"])) echo $erreurs["prenom"]; ?></span>
            <label for="nom">nom:</label>
            <input id="nom" name="nom" type="text" value="<?= $nom ?>" placeholder="enter nom ...">
            <span style="color: red;"><?php if(isset($erreurs["nom"])) echo $erreurs["nom"]; ?></span>
            <label for="email">email:</label>
            <input type="email" name="email" id="email" value="<?= $email ?>" placeholder="enter email ...">
            <span style="color: red;"><?php if(isset($erreurs["email"])) echo $erreurs["email"]; ?></span>
            <label for="password">password:</label>
            <div style="display: flex;align-items: center;">
                <input style="width:83%;" type="password" name="password" id="password" value="<?= $password ?>" placeholder="enter password ...">
                <img id="togglePassword" src="img/hidden.png">
            </div>
            <span style="color: red;"><?php if(isset($erreurs["password"])) echo $erreurs["password"]; ?></span>
            <div>
                <button name="submit">register</button>
                <p>Avez-vous déjà un compte? <a href="login.php">login</a></p>
            </div>
        </form>
    </main>
    <footer>
    </footer>
    <script>
         const passwordInput = document.getElementById("password");
         const toggleIcon = document.getElementById("togglePassword");
         toggleIcon.addEventListener("click", () => {
            const isPassword = passwordInput.type === "password";
            if(isPassword){
                passwordInput.type ="text";
                toggleIcon.src="img/show.png";
            }else{
                passwordInput.type ="password";
                toggleIcon.src="img/hidden.png";
            }
        });
    </script>
</body>
</html>