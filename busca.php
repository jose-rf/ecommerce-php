<<<<<<< HEAD
<?php
include('includes/db.php'); 

$categorias = $conn->query("SELECT * FROM categorias");
?>

<form method="GET" action="/Ecommerce/resultadosbusca.php" class="filtros-produtos">
  <input type="text" name="busca" placeholder="Buscar..." value="<?php echo htmlspecialchars($_GET['busca'] ?? '') ?>">

  <select name="categoria">
    <option value="">Todas as categorias</option>
    <?php while ($cat = $categorias->fetch_assoc()): ?>
      <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
    <?php endwhile; ?>
  </select>

  <input type="number" step="0.01" name="preco_min" placeholder="Preço mín">
  <input type="number" step="0.01" name="preco_max" placeholder="Preço máx">

  <select name="ordem">
    <option value="">Ordenar por</option>
    <option value="preco_asc">Preço: menor → maior</option>
    <option value="preco_desc">Preço: maior → menor</option>
    <option value="nome">Nome A-Z</option>
  </select>

  <button type="submit">🔍 Pesquisar</button>
</form>
=======
    <form method="GET" action="resultadosbusca.php" class="barra-pesquisa">
        <input type="text" name="busca" placeholder="Buscar produtos..." required>
        <button type="submit">🔍</button>
    </form>
>>>>>>> 08164964309196dd6220f2f30f3e30616a071e0f
