<?php
    require_once "db.php";

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nome_citta"]))
    {
        $stmt = $conn->prepare("SELECT * FROM palestre WHERE nome_citta = ?");
        $stmt->bind_param("s", $_POST["nome_citta"]);
        $stmt->execute();
        $result = $stmt->get_result();

        $palestre = "";

        while($row = $result->fetch_assoc())
        {
            $palestre .= "Palestra: " . $row["nome_palestra"] . "<br>";
            $palestre .= "Città: " . $row["nome_citta"] . "<br>";
            $palestre .= "CAP: " . $row["CAP_citta"] . "<br><br>";
        }
    }
?>

<html>
    <body>
        <form method = "post" action = "find_gym.php">
            Città: <input type="text" name="nome_citta" required><br>
            <input type="submit" value="Cerca">
        </form>
        <? 
            if(isset($palestre))
            {
                echo $palestre; 
            }
        ?>
    </body>
</html>
