<?php
require_once "conexao.php";

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
        <a href="adicionar_produtos.php" class="btn-adicionar">
            + Adicionar produto
        </a>
    </header>

    <main class="container">

        <h2>Conheça nossos produtos</h2>

        <div class="produtos">

            <?php foreach ($produtos as $produto): ?>

                <div class="card">

                    <?php
                    $imagem = $produto['imagem'] ?? '';

                    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

                    $extensao = strtolower(pathinfo($imagem, PATHINFO_EXTENSION));
                    ?>

                    <?php if (!empty($imagem) && in_array($extensao, $extensoesPermitidas)): ?>
                        <img src="uploads/<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
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

                            <a href="editar_produtos.php?id=<?= $produto['id'] ?>" class="btn-editar">Pedir</a>



                            <input type="hidden" name="id" value="<?= $produto['id'] ?>">



                            </form>

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