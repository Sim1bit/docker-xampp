<?php
    require_once "../session.php";
    require_once "../db.php";

    if(isset($_SESSION["codice"]))
    {
        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ID_studente"]) && isset($_POST["ID_classe"]))
        {
            echo "Frocio";
            $stmt = $conn->prepare("INSERT INTO Partecipazioni (ID_studente, ID_classe) VALUE (?, ?)");
            $stmt->bind_param("is", $_POST["ID_studente"], $_POST["ID_classe"]);
            $stmt->execute();
        }
    }
    else
    {
        die("Invalid request");
    }
?>

<html>
    <form action="invita_studenti.php" method="post">
        Studenti: 
        <select name="ID_studente">
            <?php
                $string = "";
                $stmt = $conn->prepare("SELECT * FROM Studenti");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc())
                {
                    $string .= "<option value=\"" . $row["ID_studente"] . "\">" . $row["nome"] . $row["cognome"] . "</option>";
                }
                echo $string;
            ?>
        </select>
        <br>
        Classi: 
        <select name="ID_classe">
            <?php
                $string = "";
                $stmt = $conn->prepare("SELECT * FROM Classi WHERE codice = ?");
                $stmt->bind_param("s", $_SESSION["codice"]);
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc())
                {
                    $string .= "<option value=\"" . $row["ID_classe"] . "\">" . $row["anno"] . $row["sezione"] . $row["materia"] . "</option>";
                }
                echo $string;
            ?>
        </select>
        <br>
        <input type="submit" value="Crea">
    </form>
</html>