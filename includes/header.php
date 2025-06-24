<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Loja Virtual</title>
  <link rel="stylesheet" href="/Ecommerce/css/style.css?v=1.0">
</head>
<body>
  <div class="topo">
    <div class="logo"><strong>Lumora</strong></div>
    <div class="menu">
      <a href="/Ecommerce/pages/carrinho.php">🛒 Carrinho</a>
      <?php if (isset($_SESSION['usuario'])): ?>
        <a href="logout.php">Sair</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="cadastro.php">Cadastro</a>
      <?php endif; ?>
    </div>
  </div>

  <h1>Bem-vindo à Loja</h1>
