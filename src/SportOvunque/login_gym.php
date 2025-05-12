<?php
    session_start();
    require_once "db.php";
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nome"]) && isset($_POST["pwd"]) && isset($_POST["cap"]))
    {
        $pwd = md5($_POST["pwd"]);
        $stmt = $conn->prepare("SELECT * FROM palestre WHERE nome_palestra = ? && pwd = ? && CAP_citta = ?");
        $stmt->bind_param("sss", $_POST["nome"], $pwd, $_POST["cap"]);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $_SESSION["nome"] = $row["nome_palestra"];
                $_SESSION["pwd"] = $row["pwd"];
                $_SESSION["cap"] = $row["CAP_citta"];

                header("Location: input_corsi.php");
            }
        }
        else
        {
            header("Location: login_gym.php");
        }
    }
?>

<html>
    <body>
        <form method="post" action="login_gym.php">
            Nome: <input type="text" name="nome" required><br>
            CAP: <input type="text" name="cap" required><br>
            Password: <input type="password" name="pwd" required><br>
            <input type="submit" value="Accedi">
        </form>
    </body>    
</html>