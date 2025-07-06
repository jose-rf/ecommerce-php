<?php
session_start(); 
include('includes/verificacao.php'); // garante que só usuário logado entra

// Verifica se o usuário é admin
$isAdmin = false;
if (isset($_SESSION['usuario'])) {
  include('includes/db.php');
  $idUsuario = $_SESSION['usuario'];
  $sqlAdmin = "SELECT administrador FROM usuarios WHERE id = ?";
  $stmt = $conn->prepare($sqlAdmin);
  $stmt->bind_param("i", $idUsuario);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
    $isAdmin = ($row['administrador'] == 1);
  }
  $stmt->close();
  if (!$isAdmin) {
    // Se não for admin, redireciona ou mostra erro
    header("Location: /Ecommerce/index.php");
    exit();
  }
} else {
  // Se não estiver logado, redireciona para login
  header("Location: /Ecommerce/login.php");
  exit();
}

include('includes/header.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Painel do Administrador</title>
  <link rel="stylesheet" href="../css/style.css" />
  <style>
    body { font-family: Arial, sans-serif; padding: 2rem; background-color: #f7f7f7; margin: 0; padding: 0; }
    h1 { color: #333; }
    .admin-links a {
      display: inline-block;
      margin: 10px;
      padding: 10px 20px;
      background-color: #E53939;
      color: white;
      text-decoration: none;
      border-radius: 8px;
    }
    .admin-links a:hover {
      background-color: #1e1e1e;
    }
  </style>
</head>
<body>
  <h1>Bem-vindo ao Painel do Administrador</h1>

  <div class="admin-links" style="text-align: center;">
    <a href="produtos.php">➕ Produtos</a>
    <a href="categorias.php">➕ Categorias</a>
    <a href="/Ecommerce/index.php">← Voltar para a loja</a>
  </div>
</body>
</html>
