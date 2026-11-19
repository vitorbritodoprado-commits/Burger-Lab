<?php
require_once "conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Produto inválido.");
}

$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$produto = $resultado->fetch_assoc();

if (!$produto) {
    die("Produto não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="cardapio.css">
</head>

<body>

    <div class="form-container">

        <h1>Produto</h1>

        <form action="atualizar_produtos.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $produto['id'] ?>">

            <label>Nome do produto</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" readonly>

            <label>Descrição</label>
            <textarea name="descricao" readonly><?= htmlspecialchars($produto['descricao'] ?? '') ?></textarea>

            <label>Preço</label>
            <input type="number" name="preco" step="0.00" min="0" value="<?= htmlspecialchars($produto['preco']) ?>"
                readonly>


            </select>

            <button type="submit" class="btn-adicionar">
                Pedir
            </button>

            <a href="cardapio_funcionario.php" class="voltar">
                Voltar ao cardápio
            </a>

        </form>

    </div>

</body>

</html>