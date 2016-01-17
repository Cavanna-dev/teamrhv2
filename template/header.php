<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php?error=notlogged");
}
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootswatch.min.css">
        <link rel="stylesheet" href="../css/jasny-bootstrap.min.css">
        <link rel="stylesheet" href="../js/select2/css/select2.css">
        <link rel="stylesheet" href="../js/select2/css/select2-bootstrap.css">
        <link rel="stylesheet" href="../css/main.css">

        <script src="../js/jquery-2.1.3.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/jasny-bootstrap.min.js"></script>
        <script src="../js/select2/js/select2.min.js"></script>
    </head>
    <body>