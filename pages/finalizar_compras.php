<?php
session_start();
include('../includes/db.php');

if (empty($_SESSION['carrinho'])) {
    echo "<h2>Carrinho vazio!</h2>";
    echo "<p><a href='../index.php'>🏠 Voltar para a loja</a></p>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Finalizar Compra</title>
</head>
<body>

    <h1>Finalizar Compra</h1>

    <div class="resumo">
        <h2>Resumo do Pedido</h2>
        <?php
        $total = 0;
        foreach ($_SESSION['carrinho'] as $id => $qtd) {
            $res = $conn->query("SELECT * FROM produtos WHERE id = $id");
            if ($res->num_rows > 0) {
                $item = $res->fetch_assoc();
                $sub = $item['preco'] * $qtd;
                echo "<p>{$item['nome']} - R$ {$item['preco']} x $qtd = R$ " . number_format($sub, 2, ',', '.') . "</p>";
                $total += $sub;
            }
        }
        echo "<h3>Total: R$ " . number_format($total, 2, ',', '.') . "</h3>";
        ?>
    </div>

    <div class="formulario">
        <h2>Dados para Entrega</h2>
        <form action="processa_compra.php" method="post">
            <label>Nome completo:</label>
            <input type="text" name="nome" required>

            <label>Endereço:</label>
            <input type="text" name="endereco" required>

            <label>CEP:</label>
            <input type="text" name="cep" required>

            <label>Forma de Pagamento:</label>
            <select name="pagamento" required>
                <option value="cartao">Cartão de Crédito</option>
                <option value="boleto">Boleto Bancário</option>
                <option value="pix">PIX</option>
            </select>

            <button type="submit">Confirmar Compra</button>
        </form>
    </div>

    <p><a href="carrinho.php">⬅️ Voltar ao carrinho</a></p>

</body>
</html>
