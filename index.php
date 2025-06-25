<?php 
session_start();

if (isset($_GET['favoritar'])) {
  $id = intval($_GET['favoritar']);
  if (!isset($_SESSION['favoritos'])) {
      $_SESSION['favoritos'] = [];
  }

  if (in_array($id, $_SESSION['favoritos'])) {
      $_SESSION['favoritos'] = array_diff($_SESSION['favoritos'], [$id]);
  } else {
      $_SESSION['favoritos'][] = $id;
  }

  header("Location: index.php");
  exit();
}

include('includes/db.php'); 
include('includes/header.php'); // isso já abre <html>, <head> e <body>
?>

<h1>Sua Loja De Tecnologia!</h1>

<div class="produtos">
  <?php
  $sql = "SELECT * FROM produtos";
  $result = $conn->query($sql);

  if ($result->num_rows === 0) {
    echo "<p style='color: red;'>Nenhum produto encontrado.</p>";
  }

  while($row = $result->fetch_assoc()):
  ?>
    <div class="produto">
      <img src="<?php echo $row['imagem']; ?>" width="150">
      <h2><?php echo $row['nome']; ?></h2>
      <p>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
      <a href="/Ecommerce/pages/carrinho.php?add=<?php echo $row['id']; ?>">Adicionar ao carrinho</a><br>
      <?php
      $id = $row['id'];
      $favoritado = isset($_SESSION['favoritos']) && in_array($id, $_SESSION['favoritos']);
      $icone = $favoritado ? '❤️' : '🤍';
      ?>
      <a href="?favoritar=<?php echo $id; ?>"><?php echo $icone; ?> Favoritar</a>
    </div>
  <?php endwhile; ?>
</div>


