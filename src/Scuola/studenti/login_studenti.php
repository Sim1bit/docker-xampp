<?php
    session_start();
    require_once "../db.php";

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ID_studente"]) && isset($_POST["pwd"]))
    {
        $stmt = $conn->prepare("SELECT * FROM Studenti WHERE ID_studente = ? AND pwd = ?");
        $pwd = md5($_POST["pwd"]);
        $stmt->bind_param("ss", $_POST["ID_studente"], $pwd);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result->fetch_assoc())
        {
            $_SESSION["ID_studente"] = $_POST["ID_studente"];
            $_SESSION["pwd"] = $pwd;

            header("Location: ../vedi_classi.php");
        }
        
    }
?>

<html>
    <form method="post" action="login_studenti.php">
        ID: <input type="text" name="ID_studente" required><br>
        PWD: <input type="password" name="pwd" required><br>
        <input type="submit" value="Login">
    </form>    
</html>