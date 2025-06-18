<?php
    require_once "session.php";
    require_once "db.php";

    if(!($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["ID_classe"])))
    {
        die("Invalid request");
    }

    if(isset($_SESSION["ID_studente"]))
    {
        $stmt = $conn->prepare("SELECT * FROM Partecipazioni WHERE ID_studente = ? AND ID_classe = ?");
        $stmt->bind_param("ii", $_SESSION["ID_studente"], $_GET["ID_classe"]);
        $stmt->execute();

        $result = $stmt->get_result();
        if(!($result->fetch_assoc()))
        {
            header("Location: ../vedi_classi.php");
        }
        $stmt = $conn->prepare("UPDATE Partecipazioni SET entra = TRUE WHERE ID_studente = ?");
        $stmt->bind_param("i", $_SESSION["ID_studente"]);
        $stmt->execute();
    }
?>

<html>
    <?php
        $string = "";

        $stmt = $conn->prepare("SELECT * FROM Offre NATURAL JOIN Giochi WHERE ID_classe = ?");
        $stmt->bind_param("i", $_GET["ID_classe"]);
        $stmt->execute();

        $result = $stmt->get_result();

        while($row = $result->fetch_assoc())
        {
            $string.="<a href=\"" . $row["ID_gioco"] . " \">" . $row["descrizione"] . "</a>"; 
        }

        echo $string;
    ?>
</html>