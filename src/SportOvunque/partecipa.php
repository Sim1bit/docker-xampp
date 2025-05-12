<?php
    require_once("session_user.php");
    require_once("db.php");

    $stmt = $conn->prepare("SELECT * FROM partecipazioni NATURAL JOIN corsi NATURAL JOIN palestre WHERE email = ?");
    $stmt->bind_param("s", $_SESSION["email"]);
    $stmt->execute();
    $result = $stmt->get_result();

    $prenotazione = "";
    while ($row = $result->fetch_assoc())
    {
        $prenotazione .= "Palestra: " . $row["nome_palestra"] . "<br>";
        $prenotazione .= "Città: " . $row["nome_citta"] . "<br>";
        $prenotazione .= "Giorno: " . $row["giorno"] . "<br>";
        $prenotazione .= "Orario: " . $row["orario"] . " Durata: " . $row["durata"] . "<br>";
        $prenotazione .= "Posti massimi: " . $row["posti"] . "<br><br><br>";
    }

    $stmt = $conn->prepare("SELECT c.ID_corso, t.nome_tipologia, p.nome_palestra, p.nome_citta, c.giorno, c.orario, c.durata, c.posti - COUNT(pa.email) AS posti_disponibili
                                FROM corsi c NATURAL JOIN tipologie_corsi t NATURAL JOIN palestre p NATURAL LEFT JOIN partecipazioni pa
                                GROUP BY c.ID_corso
                                    HAVING posti_disponibili > 0 || posti_disponibili IS NULL;");
    $stmt->execute();
    $result = $stmt->get_result();

    $corsi = "";
    while ($row = $result->fetch_assoc())
    {
        $corsi .= "Corso: " . $row["nome_tipologia"] . "<br>";
        $corsi .= "Palestra: " . $row["nome_palestra"] . "<br>";
        $corsi .= "Città: " . $row["nome_citta"] . "<br>";
        $corsi .= "Giorno: " . $row["giorno"] . "<br>";
        $corsi .= "Orario: " . $row["orario"] . " Durata: " . $row["durata"] . "<br>";
        $corsi .= "Posti rimasti: " . $row["posti_disponibili"] . "<br>";
        $corsi .= 
        "<form method = \"post\" action = \"prenota.php\">
            <input type = \"hidden\" name = \"ID_corso\" value = " . $row["ID_corso"] . ">
            <input type = \"submit\" value = \"Partecipa\">
        </form><br><br>";
    }
?>

<html>
    <body>
        <? echo $prenotazione; ?>
        <? echo $corsi; ?>
    </body>
</html>