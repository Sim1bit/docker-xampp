<?php
    session_start();
    require_once "db.php";
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"]) && isset($_POST["pwd"]))
    {
        $pwd = md5($_POST["pwd"]);
        $stmt = $conn->prepare("SELECT * FROM utenti WHERE email = ? && pwd = ?");
        $stmt->bind_param("ss", $_POST["email"], $pwd,);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $_SESSION["email"] = $row["email"];
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
            Email: <input type="mail" name="email" required><br>
            Password: <input type="password" name="pwd" required><br>
            <input type="submit" value="Accedi">
        </form>
    </body>    
</html>