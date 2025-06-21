<?php 
session_start();

if (isset($_GET['favoritar'])) {
  $id = intval($_GET['favoritar']);
  if (!isset($_SESSION['favoritos'])) {
      $_SESSION['favoritos'] = [];
  }

  if (in_array($id, $_SESSION['favoritos'])) {
      // já está favoritado → remover
      $_SESSION['favoritos'] = array_diff($_SESSION['favoritos'], [$id]);
  } else {
      // adicionar aos favoritos
      $_SESSION['favoritos'][] = $id;
  }

  // Redirecionar para evitar múltiplos cliques
  header("Location: index.php");
  exit();
}

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
        <a href="/Ecommerce/pages/carrinho.php?add=<?php echo $row['id']; ?>">🛒 Adicionar ao carrinho</a>
    <br>
    <?php
    $id = $row['id'];
    $favoritado = isset($_SESSION['favoritos']) && in_array($id, $_SESSION['favoritos']);
    $icone = $favoritado ? '❤️' : '🤍';
    ?>
    <a href="?favoritar=<?php echo $id; ?>"><?php echo $icone; ?> Favoritar</a>

      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
