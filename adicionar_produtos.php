<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
    <link rel="stylesheet" href="cardapio.css">
</head>

<body>

    <div class="form-container">

        <h1>Adicionar produto 🍔</h1>

        <form action="salvar_produtos.php" method="POST" enctype="multipart/form-data">

            <label>Nome do produto</label>
            <input type="text" name="nome" required>

            <label>Descrição</label>
            <textarea name="descricao"></textarea>

            <label>Preço</label>
            <input type="number" name="preco" step="0.01" min="0" required>

            <label>Categoria</label>
            <select name="categoria" required>
                <option value="">Selecione</option>
                <option value="Hambúrgueres">Hambúrgueres</option>
                <option value="Combos">Combos</option>
                <option value="Batatas">Batatas</option>
                <option value="Bebidas">Bebidas</option>
                <option value="Sobremesas">Sobremesas</option>
            </select>

            <label>Foto do produto</label>
            <input type="file" name="imagem" accept="image/jpeg,image/png,image/webp">

            <button type="submit" class="btn-adicionar">
                Cadastrar produto
            </button>

            <a href="cardapio.php" class="voltar">Voltar ao cardápio</a>

        </form>

    </div>

</body>

</html>