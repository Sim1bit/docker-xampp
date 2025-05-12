<?php
    require_once "session_user.php";
    require_once "db.php";

    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ID_corso"]))
    {
        $stmt = $conn->prepare("INSERT INTO partecipazioni(email, ID_corso, data_acquisto) VALUES (?, ?, CURDATE())");
        $stmt->bind_param("si", $_SESSION["email"], $_POST["ID_corso"]);
        $stmt->execute();
        
    }
    header("Location: partecipa.php");
?>