<?php
session_start();
include('../includes/db.php');

// Atualizar quantidades no carrinho (via POST)
if (isset($_POST['update'])) {
    foreach ($_POST['quantidade'] as $id => $qtd) {
        $id = intval($id);
        $qtd = intval($qtd);
        if ($qtd > 0) {
            $_SESSION['carrinho'][$id] = $qtd;
        } else {
            unset($_SESSION['carrinho'][$id]);
        }
    }
    header("Location: carrinho.php");
    exit();
}

// Adicionar item ao carrinho
if (isset($_GET['add'])) {
    $id = intval($_GET['add']);
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    $_SESSION['carrinho'][$id] = ($_SESSION['carrinho'][$id] ?? 0) + 1;
    header("Location: carrinho.php");
    exit();
}

// Remover item do carrinho
if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    unset($_SESSION['carrinho'][$id]);
    header("Location: carrinho.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Carrinho - Lumora</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>

    <?php include('../includes/header.php')?>


<main>
    <h1>Seu Carrinho</h1>

    <?php if (!empty($_SESSION['carrinho'])): 
        $total = 0;
    ?>
        <form method="post" action="carrinho.php">
            <table class="carrinho-tabela">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['carrinho'] as $id => $qtd): 
                        $id = intval($id);
                        $res = $conn->query("SELECT * FROM produtos WHERE id = $id");
                        if ($res && $res->num_rows > 0):
                            $item = $res->fetch_assoc();
                            $sub = $item['preco'] * $qtd;
                            $total += $sub;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nome']) ?></td>
                            <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                            <td>
                                <input 
                                    type="number" 
                                    name="quantidade[<?= $id ?>]" 
                                    value="<?= $qtd ?>" 
                                    min="1" 
                                    class="input-qtd" 
                                />
                            </td>
                            <td>R$ <?= number_format($sub, 2, ',', '.') ?></td>
                            <td><a href="?del=<?= $id ?>" class="btn-remover">Remover</a></td>
                        </tr>
                    <?php 
                        endif;
                    endforeach; ?>
                </tbody>
            </table>

            <div class="botoes-carrinho">
                <button type="submit" name="update" class="btn-atualizar">Atualizar Quantidades</button>
            </div>
        </form>

        <h3>Total: R$ <?= number_format($total, 2, ',', '.') ?></h3>

        <form action="finalizar_compras.php" method="post">
            <button type="submit" class="btn-finalizar">🛍️ Finalizar Compra</button>
        </form>

    <?php else: ?>
        <p>Carrinho vazio.</p>
    <?php endif; ?>
    <?php include('../includes/rodape.php')?>
</main>

</body>
</html>
