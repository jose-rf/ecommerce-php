<form method="GET" action="campobusca.php" class="form-busca">
    <input type="text" name="busca" placeholder="Buscar produtos..." required class="input-busca">
    <button type="submit" class="btn-buscar">Buscar</button>
</form>

<?php
if (isset($_GET['busca']) && $_GET['busca'] != '') {
    $termo = $conn->real_escape_string($_GET['busca']);

    $sql = "SELECT * FROM produtos WHERE nome LIKE '%$termo%'";
    $result = $conn->query($sql);

    echo "<h2 class='titulo-resultado'>Resultados para: <em>$termo</em></h2>";

    if ($result->num_rows > 0) {
        echo "<div class='lista-produtos'>";
        while ($produto = $result->fetch_assoc()) {
            echo "<div class='card-produto'>";
            echo "<h3>" . $produto['nome'] . "</h3>";
            echo "<p>Preço: R$" . number_format($produto['preco'], 2, ',', '.') . "</p>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p class='nenhum-produto'>Nenhum produto encontrado :(</p>";
    }
}
?>
