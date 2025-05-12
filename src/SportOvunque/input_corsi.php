<?php
    require_once "session_gym.php";
    require_once "db.php";

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["giorno"]) && isset($_POST["orario"]) && isset($_POST["tipologia"]) && isset($_POST["durata"]) && isset($_POST["costi"]))
    {
        $stmt = $conn->prepare("SELECT ID_palestra FROM palestre WHERE nome_palestra = ? AND CAP_citta = ?");
        $stmt->bind_param("ss", $_SESSION["nome"], $_SESSION["cap"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $ID_palestra = $result->fetch_assoc()["ID_palestra"];

        $stmt = $conn->prepare("INSERT INTO corsi(ID_palestra, ID_tipologia, giorno, orario, durata, costo, posti) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $posti;
        if(isset($_POST["posti"]))
        {
            $posti = $_POST["posti"];
        }
        else
        {
            $posti = null;
        }
        $stmt->bind_param("iissidi", $ID_palestra, $_POST["tipologia"], $_POST["giorno"], $_POST["orario"], $_POST["durata"], $_POST["costi"], $posti);
        $stmt->execute();
    }
?>



<html>
    <body>
        <form action="input_corsi.php" method="post">
            Giorni:
            <select name="giorno">
                <option value="lunedì">1</option>
                <option value="martedì">2</option>
                <option value="mercoledì">3</option>
                <option value="giovedì">4</option>
                <option value="venerdì">5</option>
                <option value="sabato">6</option>
                <option value="domenica">7</option>
            </select>
            <br>
            Orario: <input type="time" name="orario">
            <br>
            <select name="tipologia">
                <option value="1">pesi</option>
                <option value="2">zumba</option>
            </select>
            <br>
            Durata: <input type="text" name="durata">
            <br>
            Posti: <input type="text" name="posti">
            <br>
            Costi: <input type="text" name="costi">
            <br>
            <input type="submit" value="Crea Corso">    
        </form>
    </body>
</html>