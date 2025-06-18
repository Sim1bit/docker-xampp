<?php
    require_once "session.php";
    require_once "db.php";

    if(isset($_SESSION["ID_studente"]))
    {
        $stmt = $conn->prepare("SELECT * FROM Partecipazioni NATURAL JOIN Classi NATURAL JOIN Materie WHERE ID_studente = ? AND entra = TRUE");
        $stmt->bind_param("i", $_SESSION["ID_studente"]);
        $stmt->execute();

        $result = $stmt->get_result();
        $elenco = "Le tue Classi sono:<br>";
        while($row = $result -> fetch_assoc())
        {
            $elenco.=
                "<form action=\"classe.php\">
                    <input type=\"hidden\" name=\"ID_classe\" value=\"" . $row["ID_classe"] . "\">
                    <input type=\"submit\" value=\"" . $row["anno"] . $row["sezione"] . $row["nome"] . "\">
                </form><br>";
        }

        $stmt = $conn->prepare("SELECT * FROM Partecipazioni NATURAL JOIN Classi NATURAL JOIN Materie WHERE ID_studente = ? AND entra = FALSE");
        $stmt->bind_param("i", $_SESSION["ID_studente"]);
        $stmt->execute();

        $result = $stmt->get_result();
        $elenco .= "Puoi entrare in:<br>";
        while($row = $result -> fetch_assoc())
        {
            $elenco.=
                "<form action=\"classe.php\">
                    <input type=\"hidden\" name=\"ID_classe\" value=\"" . $row["ID_classe"] . "\">
                    <input type=\"submit\" value=\"" . $row["anno"] . $row["sezione"] . $row["nome"] . "\">
                </form><br>";
        }
    }
    else
    {
        $stmt = $conn->prepare("SELECT * FROM Classi NATURAL JOIN Materie WHERE codice = ?");
        $stmt->bind_param("s", $_SESSION["codice"]);
        $stmt->execute();

        $result = $stmt->get_result();
        $elenco = "";
        while($row = $result -> fetch_assoc())
        {
            $elenco.=
                "<form action=\"classe.php\">
                    <input type=\"hidden\" name=\"ID_classe\" value=\"" . $row["ID_classe"] . "\">
                    <input type=\"submit\" value=\"" . $row["anno"] . $row["sezione"] . $row["nome"] . "\">
                </form><br>";
        }
    }
?>

<html>
    <?echo $elenco;?>
</html>