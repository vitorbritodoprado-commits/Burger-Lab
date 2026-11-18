<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login do Funcionario</title>
    <link rel="stylesheet" href="style_funcionario.css">

</head>

<body>
    <div class="container">
        <h1>Bem vindo(a)!</h1>
        <p class="subtitulo">Faça login de funcionarios para continuar e acessar o sistema!</p>
        <?php
        if (isset($_GET['erro']) && $_GET['erro'] === 'login') {
            echo '<div class="mensagem-erro">Login inválido.
            Verifique email e senha.</div>';
        }
        ?>
        <form action="autenticar.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Digite seu email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="seha" name="senha" placeholder="Digite sua senha" required>
            </div>
            <a href="cardapio.php" class="botao-link">Entrar</a>

            <div class="nav-links">
        </form>
        <div class="nav-links">
            <p>Não tem uma conta? <a href="cadastro_funcionario.php">Cadastrar-se</a></p>
        </div>

</body>

</html>