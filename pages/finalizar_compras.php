<?php
session_start();
include('../includes/db.php');

// Se o usuário não estiver logado, exibe aviso visual
if (!isset($_SESSION['usuario'])) {
    echo "
    <!DOCTYPE html>
    <html lang='pt-BR'>
    <head>
      <meta charset='UTF-8'>
      <title>Acesso Restrito</title>
      <link rel='stylesheet' href='../css/style.css'>
    </head>
    <body>
      <div class='aviso-acesso'>
        <h2>Você precisa estar logado para finalizar a compra 🛑</h2>
        <p><a href='../login.php'>🔑 Fazer login</a> ou <a href='../cadastro.php'>✍️ Criar conta</a></p>
      </div>
    </body>
    </html>
    ";
    exit();
}

// Se o carrinho estiver vazio, exibe mensagem
if (empty($_SESSION['carrinho'])) {
    echo "
    <!DOCTYPE html>
    <html lang='pt-BR'>
    <head>
      <meta charset='UTF-8'>
      <title>Carrinho Vazio</title>
      <link rel='stylesheet' href='../css/style.css'>
    </head>
    <body>
      <div class='aviso-acesso'>
        <h2>Carrinho vazio!</h2>
        <p><a href='../index.php'>🏠 Voltar para a loja</a></p>
      </div>
    </body>
    </html>
    ";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Finalizar Compra - Lumora</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body class="finalizar-page">
  <div class="container-finalizar">
    <h1 class="titulo-finalizar">Finalizar Compra</h1>

    <div class="blocos-finalizar">
      <section class="resumo-compra">
        <h2>Resumo do Pedido</h2>
        <?php
        $total = 0;
        foreach ($_SESSION['carrinho'] as $id => $qtd) {
            $res = $conn->query("SELECT * FROM produtos WHERE id = $id");
            if ($res->num_rows > 0) {
                $item = $res->fetch_assoc();
                $sub = $item['preco'] * $qtd;
                echo "<p>{$item['nome']} - R$ " . number_format($item['preco'], 2, ',', '.') . 
                     " x $qtd = R$ " . number_format($sub, 2, ',', '.') . "</p>";
                $total += $sub;
            }
        }
        echo "<h3>Total: R$ " . number_format($total, 2, ',', '.') . "</h3>";
        ?>
      </section>

      <section class="formulario-entrega">
        <h2>Dados para Entrega</h2>
        <form action="processa_compra.php" method="post">
          <input type="text" name="nome" placeholder="Nome completo" required>
          <input type="text" name="endereco" placeholder="Endereço" required>
          <input type="text" name="cep" placeholder="CEP" required>
          <select name="pagamento" required>
            <option value="">Escolha a forma de pagamento</option>
            <option value="cartao">Cartão de Crédito</option>
            <option value="boleto">Boleto Bancário</option>
            <option value="pix">PIX</option>
          </select>
          <button type="submit">Confirmar Compra</button>
        </form>
      </section>
    </div>

    <p style="margin-top: 1.5rem;"><a href="carrinho.php">Voltar ao carrinho</a></p>
  </div>
</body>
</html>
