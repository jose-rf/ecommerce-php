<?php
    include('includes/header.php');//para manter a header depois da pesquisa, para manter o visual
    include('includes/bd.php');//incluir a conexao com o banco

    if (isset($_GET['busca'])) {
    $termo = trim($_GET['busca']);
    $sql = "SELECT * FROM produtos WHERE nome LIKE ?";
    $stmt = $conn->prepare($sql);
    $buscaTermo = "%" . $termo . "%";
    $stmt->bind_param("s", $buscaTermo);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <h2>Resultados para "<?php echo htmlspecialchars($termo); ?>"</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="produtos">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="produto">
                    <img src="<?php echo $row['imagem']; ?>" width="150">
                    <h3><?php echo $row['nome']; ?></h3>
                    <p>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p style="color: red;">🔍 Não encontramos o produto desejado!</p>
    <?php endif;

    $stmt->close();
}

include('includes/rodape.php');//para manter o rodape
?>

