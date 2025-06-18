<?php
    session_start();
    if(!(isset($_SESSION["pwd"])))
    {
        die("Accedi");
    }