<?php
include('includes/verificacao.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Painel do Administrador</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body { font-family: Arial, sans-serif; padding: 2rem; background-color: #f7f7f7; }
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

  <div class="admin-links">
    <a href="adicionar_produto.php">➕ Adicionar Produto</a>
    <a href="/Ecommerce/index.php">← Voltar para a loja</a>
  </div>
</body>
</html>
