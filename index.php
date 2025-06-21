<?php 
session_start();
include('includes/db.php'); 
?>
<!DOCTYPE html>
<html>
<head>
  <title>Loja Virtual</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="topo">
    <div class="logo"><strong>Minha Loja</strong></div>
    <div class="menu">
      <a href="carrinho.php">🛒 Carrinho</a>
      <?php if (isset($_SESSION['usuario'])): ?>
        <a href="logout.php">Sair</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="cadastro.php">Cadastro</a>
      <?php endif; ?>
    </div>
  </div>

  <h1>Bem-vindo à Loja</h1>

  <div class="produtos">
    <?php
    $sql = "SELECT * FROM produtos";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()):
    ?>
      <div class="produto">
        <img src="img/<?php echo $row['imagem']; ?>" width="150">
        <h2><?php echo $row['nome']; ?></h2>
        <p>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
        <a href='carrinho.php?add=<?php echo $row["id"]; ?>'>Adicionar ao carrinho</a>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
