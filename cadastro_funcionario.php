<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de funcionários - burgerlab</title>
    <link rel="stylesheet" href="style_funcionario.css">
</head>

<body>
    <div class="container">
        <h1>Cadastro de funcionários</h1>
        <p class="subtituto">Crie sua conta para acessar o sistema de funcionários</p>

        <?php
        if (isset($_GET['erro']) && $_GET['erro'] === 'email') {
            echo '<div class="mensagem-erro">Este email já está cadastrado.</div>';
        }
        ?>

        <form action="salvar_usuario.php" method="POST">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Digite seu email" required>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="number" id="telefone" name="telefone" placeholder="Digite seu telefone" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            </div>
            <div class="form-group">
                <label for="matricula">Número de matrícula</label>
                <input type="number" id="matricula" name="matricula" placeholder="Digite seu número de matrícula"
                    required>
            </div>
            <div class="form-group">
                <label for="nascimento">Data de nascimento</label>
                <input type="date" id="data" name="data" placeholder="Digite sua data de nascimento" required>
            </div>

         <a href="login_funcionario.php" class="botao-link">Cadastrar</a>
        </form>
        <div class="nav-links">
            <p>Já tem conta? <a href="login_funcionario.php"> Fazer login</a></p>
        </div>
    </div>

</body>

</html>