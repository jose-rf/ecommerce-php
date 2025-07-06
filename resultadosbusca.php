<?php
include('includes/header.php'); 
include('includes/db.php'); 

// busca todas as categorias para o <select>
$categorias = $conn->query("SELECT * FROM categorias");
?>

<!-- Formulário dos filtros -->
<form method="GET" class="filtros-produtos">
  <input type="text" name="busca" placeholder="Buscar..." value="<?php echo htmlspecialchars($_GET['busca'] ?? '') ?>">

  <select name="categoria">
    <option value="">Todas as categorias</option>
    <?php while ($cat = $categorias->fetch_assoc()): ?>
      <option value="<?= $cat['id'] ?>" <?= ($_GET['categoria'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($cat['nome']) ?>
      </option>
    <?php endwhile; ?>
  </select>

  <input type="number" name="preco_min" placeholder="Preço mín" step="0.01" value="<?= htmlspecialchars($_GET['preco_min'] ?? '') ?>">
  <input type="number" name="preco_max" placeholder="Preço máx" step="0.01" value="<?= htmlspecialchars($_GET['preco_max'] ?? '') ?>">

  <select name="ordem">
    <option value="">Ordenar por</option>
    <option value="preco_asc" <?= ($_GET['ordem'] ?? '') === 'preco_asc' ? 'selected' : '' ?>>Preço: menor → maior</option>
    <option value="preco_desc" <?= ($_GET['ordem'] ?? '') === 'preco_desc' ? 'selected' : '' ?>>Preço: maior → menor</option>
    <option value="nome" <?= ($_GET['ordem'] ?? '') === 'nome' ? 'selected' : '' ?>>Nome A-Z</option>
  </select>

  <button type="submit">Pesquisar</button>
</form>

<?php
if (!empty($_GET)) {

  $where = [];
  $params = [];
  $types = "";

  if (!empty($_GET['busca'])) {
    $where[] = "p.nome LIKE ?";
    $params[] = "%" . $_GET['busca'] . "%";
    $types .= "s";
  }

  if (!empty($_GET['categoria'])) {
    $where[] = "p.categoria_id = ?";
    $params[] = $_GET['categoria'];
    $types .= "i";
  }

  if (!empty($_GET['preco_min'])) {
    $where[] = "p.preco >= ?";
    $params[] = $_GET['preco_min'];
    $types .= "d";
  }

  if (!empty($_GET['preco_max'])) {
    $where[] = "p.preco <= ?";
    $params[] = $_GET['preco_max'];
    $types .= "d";
  }

  
  $order = "";
  if (!empty($_GET['ordem'])) {
    if ($_GET['ordem'] === 'preco_asc') $order = " ORDER BY p.preco ASC";
    elseif ($_GET['ordem'] === 'preco_desc') $order = " ORDER BY p.preco DESC";
    elseif ($_GET['ordem'] === 'nome') $order = " ORDER BY p.nome ASC";
  }

  // Monta SQL
  $sql = "SELECT p.*, c.nome AS categoria_nome
          FROM produtos p
          LEFT JOIN categorias c ON p.categoria_id = c.id";

  if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
  }

  $sql .= $order;

  // Executa a consulta
  $stmt = $conn->prepare($sql);
  if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
  }
  $stmt->execute();
  $result = $stmt->get_result();
  ?>

  <h2>Resultados da busca</h2>

  <?php if ($result->num_rows > 0): ?>
    <div class="produtos">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="produto">
          <img src="<?= $row['imagem'] ?>" width="150">
          <h3><?= htmlspecialchars($row['nome']) ?></h3>
          <p>R$ <?= number_format($row['preco'], 2, ',', '.') ?></p>
          <p>Categoria: <?= htmlspecialchars($row['categoria_nome']) ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p style="color: red;">🔍 Nenhum produto encontrado com os filtros aplicados.</p>
  <?php endif;

  $stmt->close();
}
?>

<?php include('includes/rodape.php'); ?>

