<?php
session_start();
include('../includes/db.php');

if (isset($_GET['add'])) {
    $id = intval($_GET['add']);
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    $_SESSION['carrinho'][$id] = ($_SESSION['carrinho'][$id] ?? 0) + 1;
    header("Location: carrinho.php");
    exit();
}

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    unset($_SESSION['carrinho'][$id]);
    header("Location: carrinho.php");
    exit();
}

echo "<h1>Seu Carrinho</h1>";
echo '<p><a href="javascript:history.back()">⬅️ Voltar</a> | <a href="../index.php">🏠 Loja</a></p>';
$total = 0;
if (!empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $id => $qtd) {
        $res = $conn->query("SELECT * FROM produtos WHERE id = $id");
        if ($res->num_rows > 0) {
            $item = $res->fetch_assoc();
            $sub = $item['preco'] * $qtd;
            echo "<p>{$item['nome']} - R$ {$item['preco']} x $qtd = R$ $sub ";
            echo "<a href='?del=$id'>[Remover]</a></p>";
            $total += $sub;
        }
    }
    echo "<h3>Total: R$ $total</h3>";
    echo "<form action='finalizar_compras.php' method='post'>
    <button type='submit'>🛍️ Finalizar Compra</button>
</form>";

} else {
    echo "<p>Carrinho vazio.</p>";
}
?>
