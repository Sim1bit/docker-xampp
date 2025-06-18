<?php
    require_once "../db.php";

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["codice"]) && isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["pwd"]))
    {
        $stmt = $conn->prepare("INSERT INTO Docenti (codice, nome, cognome, pwd) VALUES (?, ?, ?, ?)");
        $pwd = md5($_POST["pwd"]);
        $stmt->bind_param("ssss", $_POST["codice"], $_POST["nome"], $_POST["cognome"], $pwd);
        $stmt->execute();
    }
?>

<html>
    <form method="post" action="registrazione_docenti.php">
        Codice: <input type="text" name="codice" required><br>
        Nome: <input type="text" name="nome" required><br>
        Cognome: <input type="text" name="cognome" required><br>
        PWD: <input type="password" name="pwd" required><br>
        <input type="submit" value="Registrati">
    </form>    
</html>