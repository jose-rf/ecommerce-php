<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Loja Virtual</title>
  <link rel="stylesheet" href="/Ecommerce/css/style.css?v=1.0">
</head>
<body>
  <div class="topo">
    <div class="logo"><img src="/Ecommerce/imagens/lumora2.png" alt="Logo lumora"></div>
    <div class="menu">
      <a href="/Ecommerce/pages/carrinho.php">Carrinho</a>
      <?php if (isset($_SESSION['usuario'])): ?>
        <a href="logout.php">Sair</a>
      <?php else: ?>
        <a href="/Ecommerce/login.php">Login</a>
        <a href="/Ecommerce/cadastro.php">Cadastro</a>
      <?php endif; ?>
    </div>
  </div>
