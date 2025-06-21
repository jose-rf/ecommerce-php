<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['usuario'])) {
    echo "Você precisa estar logado para finalizar a compra.";
    exit();
}

$usuario_id = $_SESSION['usuario'];
$conn->query("INSERT INTO pedidos (usuario_id) VALUES ($usuario_id)");
$pedido_id = $conn->insert_id;

foreach ($_SESSION['carrinho'] as $produto_id => $qtd) {
    $conn->query("INSERT INTO itens_pedido (pedido_id, produto_id, quantidade) 
                  VALUES ($pedido_id, $produto_id, $qtd)");
}

unset($_SESSION['carrinho']);
echo "Compra finalizada com sucesso! <a href='index.php'>Voltar para a loja</a>";
?>
