<?php
    require_once "session.php";
    require_once "db.php";

    $option_apiari = "";

    $stmt = $conn -> prepare("SELECT * FROM Apiari WHERE mail = ?");
    $stmt -> bind_param("s", $_SESSION["mail"]);
    $stmt -> execute();
    $result = $stmt -> get_result();

    while($row = $result -> fetch_assoc())
    {
        $option_apiari .= "<option value=\"" . $row["ID_apiario"] . "\">" . $row["ID_apiario"] . " " . $row["num_arnie"] . "</option>";
    }

    $option_miele = "";

    $stmt = $conn -> prepare("SELECT ID_miele, nome, ADD(quantita) FROM Miele GROUP BY ID_miele");
    $stmt -> bind_param("s", $_SESSION["mail"]);
    $stmt -> execute();
    $result = $stmt -> get_result();

    while($row = $result -> fetch_assoc())
    {
        $option_miele .= "<option value=\"" . $row["ID_Miele"] . "\">" . $row["nome"] . "</option>";
    }
?>

<html>
    <selection><? echo $option_apiari; ?></selection>
    <selection><? echo $option_miele; ?></selection>
</html>