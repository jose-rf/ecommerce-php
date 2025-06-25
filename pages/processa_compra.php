<?php
session_start();
include('../includes/db.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

// Verifica se o carrinho está vazio
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    header("Location: ../index.php");
    exit();
}

$usuario_id = $_SESSION['usuario'];

// Cria o pedido
$stmt = $conn->prepare("INSERT INTO pedidos (usuario_id) VALUES (?)");
$stmt->bind_param("i", $usuario_id);
if (!$stmt->execute()) {
    die("Erro ao criar pedido: " . $stmt->error);
}
$pedido_id = $stmt->insert_id;
$stmt->close();

// Insere os itens do pedido
$stmt_item = $conn->prepare("INSERT INTO itens_pedido (pedido_id, produto_id, quantidade) VALUES (?, ?, ?)");
foreach ($_SESSION['carrinho'] as $produto_id => $qtd) {
    $stmt_item->bind_param("iii", $pedido_id, $produto_id, $qtd);
    if (!$stmt_item->execute()) {
        die("Erro ao inserir item do pedido: " . $stmt_item->error);
    }
}
$stmt_item->close();

// Limpa o carrinho da sessão
unset($_SESSION['carrinho']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Compra Finalizada</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/mensagem.css">
</head>
<body>
  <div class="mensagem-final">
    <h2>Compra finalizada com sucesso!</h2>
    <p>Obrigado por comprar com a Lumora.</p>
    <a href="../index.php">Voltar para a loja</a>
  </div>
</body>
</html>
