<?php
include('includes/db.php');

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "E-mail inválido.";
    } else {
        $existe = $conn->query("SELECT * FROM usuarios WHERE email = '$email'");
        if ($existe->num_rows > 0) {
            $mensagem = "Este e-mail já está cadastrado.";
        } else {
            $conn->query("INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')");
            $mensagem = "✅ Cadastro realizado com sucesso! <a href='login.php'>Clique aqui para fazer login</a>.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro - Lumora</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    .mensagem {
      text-align: center;
      margin-top: 1rem;
      font-weight: bold;
      font-family: 'Inter', sans-serif;
      color: #444;
    }

    .mensagem a {
      color: var(--vermelho);
      text-decoration: underline;
    }
  </style>
</head>
<body class="loginz">
  <div class="caixa-login">
    <form method="POST">
      <h2>Cadastro</h2>
      <input type="text" name="nome" placeholder="Seu nome" required>
      <input type="email" name="email" placeholder="Seu e-mail" required>
      <input type="password" name="senha" placeholder="Sua senha" required>
      <button type="submit">Cadastrar</button>
    </form>

    <?php if (!empty($mensagem)): ?>
      <div class="mensagem"><?= $mensagem ?></div>
    <?php endif; ?>
  </div>
</body>
</html>
