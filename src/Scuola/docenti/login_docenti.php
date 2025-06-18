<?php
    session_start();
    require_once "../db.php";

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["codice"]) && isset($_POST["pwd"]))
    {
        $pwd = md5($_POST["pwd"]);
        $stmt = $conn->prepare("SELECT * FROM Docenti WHERE codice = ? AND pwd = ?");
        $stmt->bind_param("ss", $_POST["codice"], $pwd);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->fetch_assoc())
        {
            $_SESSION["codice"] = $_POST["codice"];
            $_SESSION["pwd"] = $pwd;

            header("Location: ../vedi_classi.php");
        }
    }
?>

<html>
    <form method="post" action="login_docenti.php">
        Codice: <input type="text" name="codice" required><br>
        PWD: <input type="password" name="pwd" required><br>
        <input type="submit" value="Login">
    </form>    
</html>