<?php
    require_once "../session.php";
    require_once "../db.php";

    if(isset($_SESSION["codice"]))
    {
        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["anno"]) && isset($_POST["sezione"]) && isset($_POST["materie"]))
        {
            $stmt = $conn->prepare("INSERT INTO Classi (anno, sezione, ID_materia, codice) VALUE (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $_POST["anno"], $_POST["sezione"], $_POST["materie"], $_SESSION["codice"]);
            $stmt->execute();
        }
    }
?>

<html>
    <form action="crea_classi.php" method="post">
        Anno: <input type="text" name="anno" required><br>
        Sezione: <input type="text" name="sezione" required><br>
        Materia: 
        <select name="materie">
            <?php
                $string = "";
                $stmt = $conn->prepare("SELECT * FROM Materie");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc())
                {
                    $string .= "<option value=\"" . $row["ID_materia"] . "\">" . $row["nome"] . "</option>";
                }
                echo $string;
            ?>
        </select>
        <br>
        <input type="submit" value="Crea">
    </form>
</html>