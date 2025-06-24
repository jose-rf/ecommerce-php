<?php
session_start();
include('includes/db.php');

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario'] = $user['id'];
            header("Location: index.php");
            exit();
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado. <a href='cadastro.php'>Clique aqui para se cadastrar</a>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Login - Lumora</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    .erro-login {
      background-color: #ffe8e8;
      border: 1px solid #e53939;
      padding: 1rem;
      border-radius: 8px;
      margin-top: 1rem;
      color: #b20000;
      text-align: center;
      font-weight: bold;
    }

    .erro-login a {
      color: var(--vermelho);
      text-decoration: underline;
    }

    .caixa-login button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background-color: var(--vermelho);
      color: var(--branco);
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s;
      margin-top: 10px;
    }

    .caixa-login button:hover {
      background-color: #c52f2f;
    }
  </style>
</head>
<body class="loginz">
  <div class="caixa-login">
    <form method="POST">
      <h2>Login</h2>
      <input type="email" name="email" placeholder="Seu e-mail" required>
      <input type="password" name="senha" placeholder="Sua senha" required>
      <button type="submit">Entrar</button>
    </form>

    <?php if (!empty($erro)): ?>
      <div class="erro-login"><?= $erro ?></div>
    <?php endif; ?>
  </div>
</body>
</html>
