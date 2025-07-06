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

// Adicionar nova categoria
if (isset($_POST['tipo']) && $_POST['tipo'] === 'categoria' && empty($_POST['id'])) {
  $stmt = $conn->prepare("INSERT INTO categorias (nome) VALUES (?)");
  $stmt->bind_param("s", $_POST['nome']);
  $stmt->execute();
  $mensagem = "✅ Categoria adicionada!";
  $stmt->close();
}

// Atualizar categoria existente
if (isset($_POST['tipo']) && $_POST['tipo'] === 'categoria' && !empty($_POST['id'])) {
  $stmt = $conn->prepare("UPDATE categorias SET nome=? WHERE id=?");
  $stmt->bind_param("si", $_POST['nome'], $_POST['id']);
  $stmt->execute();
  $mensagem = "✏️ Categoria atualizada!";
  $stmt->close();
}

// Deletar categoria com verificação de vínculo
if (isset($_GET['deletar_categoria'])) {
  $id = intval($_GET['deletar_categoria']);

  // Verifica se há produtos vinculados à categoria
  $sql_check = "SELECT COUNT(*) as total FROM produtos WHERE categoria_id = $id";
  $result_check = $conn->query($sql_check);
  $row_check = $result_check->fetch_assoc();

  if ($row_check['total'] > 0) {
    $mensagem = "❌ Não é possível excluir essa categoria pois existem produtos vinculados a ela.";
  } else {
    if ($conn->query("DELETE FROM categorias WHERE id=$id")) {
      $mensagem = "✅ Categoria excluída com sucesso!";
    } else {
      $mensagem = "❌ Erro ao excluir categoria: " . $conn->error;
    }
  }
}

// Busca as categorias para listar
$categorias = $conn->query("SELECT * FROM categorias");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Gerenciar Categorias</title>
  <style>
    body { font-family: Arial; background: #f4f4f4; padding: 0; margin: 0; }
    form, table { background: #fff; padding: 1rem; margin-bottom: 2rem; border-radius: 8px; width: 100%; max-width: 600px; margin-left:auto; margin-right:auto; }
    input, button { width: 100%; padding: 10px; margin-bottom: 10px; border-radius: 6px; border: 1px solid #ccc; }
    table { border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    th { background: #eee; }
    .mensagem { text-align: center; font-weight: bold; color: green; max-width: 600px; margin: 10px auto; }
    .mensagem.erro { color: red; }
    .acoes a { margin-right: 10px; text-decoration: none; color: #E53939; font-weight: bold; cursor: pointer; }
  </style>
</head>
<body>

<h1 style="text-align:center;">Gerenciar Categorias</h1>

<?php if (!empty($mensagem)): ?>
  <p class="mensagem <?= strpos($mensagem, '❌') !== false ? 'erro' : '' ?>"><?= $mensagem ?></p>
<?php endif; ?>

<h2 style="text-align:center;">Adicionar / Editar Categoria</h2>
<form method="POST">
  <input type="hidden" name="tipo" value="categoria">
  <input type="hidden" name="id" id="categoria_id">
  <input type="text" name="nome" id="categoria_nome" placeholder="Nome da categoria" required>
  <button type="submit">Salvar Categoria</button>
</form>

<h2 style="text-align:center;">Categorias</h2>
<table>
  <tr><th>Nome</th><th>Ações</th></tr>
  <?php foreach ($categorias as $c): ?>
    <tr>
      <td><?= htmlspecialchars($c['nome']) ?></td>
      <td class="acoes">
        <a href="#" onclick="editarCategoria(<?= $c['id'] ?>, '<?= addslashes(htmlspecialchars($c['nome'])) ?>')">✏️</a>
        <a href="?deletar_categoria=<?= $c['id'] ?>" onclick="return confirm('Excluir categoria?')">❌</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>

<script>
  function editarCategoria(id, nome) {
    document.getElementById('categoria_id').value = id;
    document.getElementById('categoria_nome').value = nome;
    window.scrollTo(0, 0);
  }
</script>

</body>
</html>
