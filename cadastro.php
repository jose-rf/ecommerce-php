<?php
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $conn->query("INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')");
    echo "Usuário cadastrado com sucesso! <a href='login.php'>Login</a>";
}
?>
<form method="POST">
    <h2>Cadastro</h2>
    Nome: <input type="text" name="nome" required><br>
    Email: <input type="email" name="email" required><br>
    Senha: <input type="password" name="senha" required><br>
    <button type="submit">Cadastrar</button>
</form>
