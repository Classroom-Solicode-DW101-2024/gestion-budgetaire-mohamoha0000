<?php
require "functions/user.php";
$error=[];
$email=isset($_GET["email"]) ? $_GET["email"] : "";
if(isset($_POST["submit"])){
    $password = $_POST["password"];
    $email = $_POST["email"];
    if(!empty($password)&&filter_var($email,FILTER_VALIDATE_EMAIL)){
        $id=login($password,$email);
        if($id>0){
            $_SESSION["id"]=$id;
            header("Location:dashboard.php");
        }else{
            $error["incorrect"]="password or email incorrect";
        }
    }else{
        if(empty($password)){
            $error["password"] = "Please enter your password.";
        }
        if(empty($email)){
            $error["email"] = "Please enter your email.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
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
    </style>
</head>
<body>
    <header></header>
    <main>
        <form method="post">
            <label for="email">email:</label>
            <input type="email" id="email" name="email" value="<?php if(isset($email)) echo $email; ?>" placeholder="enter email ...">
            <span style="color: red;"><?php if(isset($error["email"])) {echo $error["email"];} ?></span>
            <label for="password">password:</label>
            <div style="display: flex;align-items: center;">
                <input style="width:87%;" type="password" name="password" id="password" placeholder="enter password ...">
                <img id="togglePassword" src="img/hidden.png">
            </div>
            <span style="color: red;"><?php if(isset($error["password"])) {echo $error["password"];} ?></span>
            <span style="color: red;"><?php if(isset($error["incorrect"])) echo $error["incorrect"]; ?></span>
            <div>
                <button name="submit">login</button>
                <p>Vous n'avez pas de compte? <a href="register.php">register</a></p>
            </div>
        </form>
    </main>
    <footer></footer>
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