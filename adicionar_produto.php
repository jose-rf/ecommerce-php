<?php
session_start();
include('includes/db.php');
include('includes/verificacao.php'); // garante que só admin entra

$mensagem = '';

// Verifica se o formulário de produto foi enviado
if (isset($_POST['tipo']) && $_POST['tipo'] === 'produto') {
  $nome = $_POST['nome'];
  $descricao = $_POST['descricao'];
  $preco = $_POST['preco'];
  $imagem = $_POST['imagem'];
  $categoria_id = $_POST['categoria_id'];

  $sql = "INSERT INTO produtos (nome, descricao, preco, imagem, categoria_id) 
          VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssdsi", $nome, $descricao, $preco, $imagem, $categoria_id);

  if ($stmt->execute()) {
    $mensagem = "✅ Produto adicionado com sucesso!";
  } else {
    $mensagem = "❌ Erro ao adicionar produto: " . $conn->error;
  }

  $stmt->close();
}

// Verifica se o formulário de categoria foi enviado
if (isset($_POST['tipo']) && $_POST['tipo'] === 'categoria') {
  $nova_categoria = $_POST['nova_categoria'];
  if (!empty($nova_categoria)) {
    $stmt = $conn->prepare("INSERT INTO categorias (nome) VALUES (?)");
    $stmt->bind_param("s", $nova_categoria);
    if ($stmt->execute()) {
      $mensagem = "✅ Categoria adicionada com sucesso!";
    } else {
      $mensagem = "❌ Erro ao adicionar categoria: " . $conn->error;
    }
    $stmt->close();
  }
}

// Atualiza as categorias após possível inserção
$categorias = $conn->query("SELECT id, nome FROM categorias");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Adicionar Produto</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      padding: 2rem;
    }

    h1, h2 {
      text-align: center;
      color: #333;
    }

    form {
      max-width: 500px;
      margin: 20px auto;
      padding: 1rem;
      background: #f4f4f4;
      border-radius: 10px;
    }

    input, textarea, select {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    button {
      padding: 10px 20px;
      background: #E53939;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      background-color: #34495e;
    }

    .mensagem {
      text-align: center;
      margin-top: 10px;
      font-weight: bold;
      color: green;
    }

    .admin-links a {
      display: inline-block;
      margin: 10px;
      padding: 10px 20px;
      color: #E53939;
      text-decoration: none;
      border-radius: 8px;
    }
  </style>
</head>
<body>
  <h1>Adicionar Produto</h1>

  <?php if (!empty($mensagem)): ?>
    <p class="mensagem"><?= $mensagem ?></p>
  <?php endif; ?>

  <!-- Formulário de Produto -->
  <form method="POST">
    <input type="hidden" name="tipo" value="produto">
    <input type="text" name="nome" placeholder="Nome do produto" required>
    <textarea name="descricao" placeholder="Descrição do produto"></textarea>
    <input type="number" step="0.01" name="preco" placeholder="Preço (ex: 1299.99)" required>
    <input type="text" name="imagem" placeholder="URL da imagem" required>

    <select name="categoria_id" required>
      <option value="">Selecione a categoria</option>
      <?php while ($cat = $categorias->fetch_assoc()): ?>
        <option value="<?= $cat['id'] ?>"><?= $cat['nome'] ?></option>
      <?php endwhile; ?>
    </select>

    <button type="submit">Salvar Produto</button>
  </form>

  <!-- Formulário de Categoria -->
  <h2>Adicionar Nova Categoria</h2>

  <form method="POST">
    <input type="hidden" name="tipo" value="categoria">
    <input type="text" name="nova_categoria" placeholder="Nome da nova categoria" required>
    <button type="submit">Salvar Categoria</button>
  </form>

  <div class="admin-links">
    <a href="/Ecommerce/admin.php">← Voltar para o painel</a>
    <a href="/Ecommerce/index.php">← Voltar para a loja</a>
  </div>
  
</body>
</html>
