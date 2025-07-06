<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('db.php');

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

$id = intval($_SESSION['usuario']);
$sql = "SELECT administrador FROM usuarios WHERE id = $id";
$res = $conn->query($sql);
$user = $res->fetch_assoc();

if (!$user || !$user['administrador']) {
    echo "Acesso negado. Esta área é restrita para administradores.";
    exit();
}
