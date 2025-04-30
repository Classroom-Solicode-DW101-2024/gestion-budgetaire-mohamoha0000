<?php 
require "functions/dashboard.php";
if(!isset($_SESSION["id"])) header("Location:login.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
</head>
<body>
    <div id="header-container"></div>
    <main>
        <h1 style="text-align: center;">coming soon...</h1>
    </main>
    <footer></footer>

    <script>
    fetch("header.html")
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