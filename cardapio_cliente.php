<?php
require_once "conexao.php";
require_once "imagem_produto.php";

$sql = "SELECT * FROM produtos ORDER BY id DESC";
$resultado = $conexao->query($sql);

if (!$resultado) {
    die("Erro ao buscar produtos: " . $conexao->error);
}

$produtos = $resultado->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio - Lanchonete</title>
    <link rel="stylesheet" href="cardapio.css">
</head>

<body>

    <header class="topo">
        <h1>Nosso Cardápio</h1>
    </header>

    <main class="container">

        <h2>Conheça nossos produtos</h2>

        <div class="produtos">

            <?php foreach ($produtos as $produto): ?>

                <div class="card">

                    <?php $urlImagem = urlImagemProduto($produto['imagem'] ?? '', $produto['id']); ?>

                    <?php if ($urlImagem): ?>
                        <img class="produto-img" src="<?= htmlspecialchars($urlImagem) ?>"
                            alt="<?= htmlspecialchars($produto['nome']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="com-imagem"></div>
                    <?php endif; ?>

                    <div class="card-conteudo">

                        <h3><?= htmlspecialchars($produto['nome']) ?></h3>

                        <p><?= htmlspecialchars($produto['descricao'] ?? '') ?></p>

                        <span class="preco">
                            R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                        </span>

                        <span class="categoria">
                            <h3>
                                <?= htmlspecialchars($produto['categoria'] ?? '') ?>
                            </h3>
                        </span>

                        <div class="acoes">
                            <a href="editar_produtos.php?id=<?= (int) $produto['id'] ?>" class="btn-editar">Pedir</a>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

            <?php if (empty($produtos)): ?>
                <p>Nenhum produto cadastrado.</p>
            <?php endif; ?>

        </div>
    </main>

</body>

</html>