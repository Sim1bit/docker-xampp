<?php
    session_start();
    require_once "db.php";
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["mail"]) && isset($_POST["pwd"]))
    {
        $pwd = md5($_POST["pwd"]);
        $stmt = $conn->prepare("SELECT * FROM Utenti WHERE mail = ? && pwd = ?");
        $stmt->bind_param("ss", $_POST["mail"], $pwd,);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $_SESSION["mail"] = $row["mail"];
                $_SESSION["pwd"] = $row["pwd"];

                header("Location: input_produzione.php");
            }
        }
        else
        {
            header("Location: login.php");
        }
    }
?>

<html>
    <body>
        <form method="post" action="login.php">
            Email: <input type="mail" name="mail" required><br>
            Password: <input type="password" name="pwd" required><br>
            <input type="submit" value="Accedi">
        </form>
    </body>    
</html>