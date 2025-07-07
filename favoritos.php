<?php
session_start();
include('includes/header.php');
include('includes/db.php');

// verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    echo "<p style='color:red;'>Você precisa estar logado para ver seus favoritos!</p>";
    include('includes/rodape.php');
    exit();
}

// tratamento do botão "Desfavoritar"
if (isset($_GET['remover'])) {
    $idRemover = intval($_GET['remover']);
    $_SESSION['favoritos'] = array_diff($_SESSION['favoritos'], [$idRemover]);

    // redireciona limpando o parâmetro da URL
    header("Location: favoritos.php");
    exit();
}

// verifica se existem produtos favoritados
if (!isset($_SESSION['favoritos']) || empty($_SESSION['favoritos'])) {
    echo "<h2>Favoritos</h2>";
    echo "<p>🧐 Você ainda não favoritou nenhum produto.</p>";
    include('includes/rodape.php');
    exit();
}

// monta a lista de IDs dos favoritos para consulta
$favoritos = $_SESSION['favoritos'];
$placeholders = implode(',', array_fill(0, count($favoritos), '?'));
$sql = "SELECT * FROM produtos WHERE id IN ($placeholders)";
$stmt = $conn->prepare($sql);

// adiciona os parâmetros dinamicamente
$stmt->bind_param(str_repeat('i', count($favoritos)), ...$favoritos);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Meus Produtos Favoritados ❤️</h2>";
echo "<div class='produtos'>";

while ($row = $result->fetch_assoc()) {
?>
    <div class="produto" style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
        <img src="<?php echo $row['imagem']; ?>" width="150">
        <h3><?php echo htmlspecialchars($row['nome']); ?></h3>
        <p>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></p>

        <!-- Botão para adicionar ao carrinho -->
        <a href="/Ecommerce/pages/carrinho.php?add=<?php echo $row['id']; ?>">🛒 Adicionar ao carrinho</a><br>

        <!-- Botão para desfavoritar -->
        <a href="?remover=<?php echo $row['id']; ?>" style="color: red;">❌ Desfavoritar</a>
    </div>
<?php
}
echo "</div>";

include('includes/rodape.php');
?>