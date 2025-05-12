<?php
    session_start();
    if(!(isset($_SESSION["nome"]) && isset($_SESSION["pwd"]) && isset($_SESSION["cap"])))
    {
        die("");
    }