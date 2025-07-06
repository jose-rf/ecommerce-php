<?php
session_start();
include('includes/db.php');
include('includes/verificacao.php');

// MENU
$isAdmin = false;
if (isset($_SESSION['usuario'])) {
  $idUsuario = $_SESSION['usuario'];
  $sqlAdmin = "SELECT administrador FROM usuarios WHERE id = ?";
  $stmt = $conn->prepare($sqlAdmin);
  $stmt->bind_param("i", $idUsuario);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
    $isAdmin = $row['administrador'] == 1;
  }
  $stmt->close();
}

include('includes/header.php');

$mensagem = '';

if (isset($_POST['tipo']) && $_POST['tipo'] === 'produto' && empty($_POST['id'])) {
  $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, preco, imagem, categoria_id) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("ssdsi", $_POST['nome'], $_POST['descricao'], $_POST['preco'], $_POST['imagem'], $_POST['categoria_id']);
  $stmt->execute();
  $mensagem = "✅ Produto adicionado!";
  $stmt->close();
}

if (isset($_POST['tipo']) && $_POST['tipo'] === 'produto' && !empty($_POST['id'])) {
  $stmt = $conn->prepare("UPDATE produtos SET nome=?, descricao=?, preco=?, imagem=?, categoria_id=? WHERE id=?");
  $stmt->bind_param("ssdssi", $_POST['nome'], $_POST['descricao'], $_POST['preco'], $_POST['imagem'], $_POST['categoria_id'], $_POST['id']);
  $stmt->execute();
  $mensagem = "✏️ Produto atualizado!";
  $stmt->close();
}

if (isset($_GET['deletar_produto'])) {
  $id = intval($_GET['deletar_produto']);
  $conn->query("DELETE FROM produtos WHERE id=$id");
  $mensagem = "❌ Produto excluído!";
}

$categorias = $conn->query("SELECT * FROM categorias");
$produtos = $conn->query("SELECT produtos.*, categorias.nome AS nome_categoria FROM produtos LEFT JOIN categorias ON produtos.categoria_id = categorias.id");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Gerenciar Produtos</title>
  <style>
    body {
      font-family: Arial;
      background: #f4f4f4;
      padding: 0;
      margin:0;
    }
    main {
      max-width: 700px;
      margin: 0 auto;
      padding: 1rem;
      border-radius: 8px;
      box-sizing: border-box;
    }
    form, table {
      background: #fff;
      padding: 1rem;
      margin-bottom: 2rem;
      border-radius: 8px;
      width: 100%;
      box-sizing: border-box;
    }
    input, textarea, select, button {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }
    th {
      background: #eee;
    }
    .mensagem {
      text-align: center;
      font-weight: bold;
      color: green;
      margin-bottom: 1rem;
    }
    .acoes a {
      margin-right: 10px;
      text-decoration: none;
      color: red;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <main>
    <h1 style="text-align:center;">Gerenciar Produtos</h1>

    <?php if (!empty($mensagem)): ?>
      <p class="mensagem"><?= $mensagem ?></p>
    <?php endif; ?>

    <h2 style="text-align:center;">Adicionar / Editar Produto</h2>
    <form method="POST">
      <input type="hidden" name="tipo" value="produto">
      <input type="hidden" name="id" id="produto_id">
      <input type="text" name="nome" id="produto_nome" placeholder="Nome do produto" required>
      <textarea name="descricao" id="produto_descricao" placeholder="Descrição"></textarea>
      <input type="number" name="preco" id="produto_preco" step="0.01" placeholder="Preço" required>
      <input type="text" name="imagem" id="produto_imagem" placeholder="URL da imagem" required>
      <select name="categoria_id" id="produto_categoria" required>
        <option value="">Selecione a categoria</option>
        <?php foreach ($categorias as $cat): ?>
          <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit">Salvar Produto</button>
    </form>

    <h2 style="text-align:center;">Produtos</h2>
    <table>
      <tr><th>Nome</th><th>Preço</th><th>Categoria</th><th>Ações</th></tr>
      <?php foreach ($produtos as $p): ?>
        <tr>
          <td><?= htmlspecialchars($p['nome']) ?></td>
          <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
          <td><?= htmlspecialchars($p['nome_categoria']) ?></td>
          <td class="acoes">
            <a href="#" onclick='editarProduto(<?= json_encode($p, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) ?>)'>✏️</a>
            <a href="?deletar_produto=<?= $p['id'] ?>" onclick="return confirm('Excluir produto?')">❌</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </main>

  <script>
    function editarProduto(p) {
      document.getElementById('produto_id').value = p.id;
      document.getElementById('produto_nome').value = p.nome;
      document.getElementById('produto_descricao').value = p.descricao;
      document.getElementById('produto_preco').value = p.preco;
      document.getElementById('produto_imagem').value = p.imagem;
      document.getElementById('produto_categoria').value = p.categoria_id;
      window.scrollTo(0, 0);
    }
  </script>
</body>
</html>
