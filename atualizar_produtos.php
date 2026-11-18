<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cardapio.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("ID inválido.");
}

$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$produto = $stmt->get_result()->fetch_assoc();

if (!$produto) {
    die("Produto não encontrado.");
}

$nome = trim($_POST["nome"] ?? "");
$descricao = trim($_POST["descricao"] ?? "");
$preco = $_POST["preco"] ?? "";
$categoria = trim($_POST["categoria"] ?? "");

if ($nome === "" || !is_numeric($preco) || $preco < 0) {
    die("Preencha os campos corretamente.");
}

$imagem = $produto["imagem"];
$novaImagemSalva = null;

if (
    isset($_FILES["imagem"]) &&
    $_FILES["imagem"]["error"] !== UPLOAD_ERR_NO_FILE
) {

    if ($_FILES["imagem"]["error"] !== UPLOAD_ERR_OK) {
        die("Erro ao enviar imagem.");
    }

    if ($_FILES["imagem"]["size"] > 5 * 1024 * 1024) {
        die("A imagem deve ter no máximo 5MB.");
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $tipo = $finfo->file($_FILES["imagem"]["tmp_name"]);

    $permitidos = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp"
    ];

    if (!isset($permitidos[$tipo])) {
        die("Formato de imagem inválido.");
    }

    if (!is_dir("uploads")) {
        mkdir("uploads", 0755, true);
    }

    $novaImagem = bin2hex(random_bytes(16)) . "." . $permitidos[$tipo];

    if (
        !move_uploaded_file(
            $_FILES["imagem"]["tmp_name"],
            "uploads/" . $novaImagem
        )
    ) {
        die("Erro ao salvar imagem.");
    }

    $imagem = $novaImagem;
    $novaImagemSalva = $novaImagem;
}

$sql = "UPDATE produtos SET
        nome = ?,
        descricao = ?,
        preco = ?,
        categoria = ?,
        imagem = ?
        WHERE id = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ssdssi",
    $nome,
    $descricao,
    $preco,
    $categoria,
    $imagem,
    $id
);

if ($stmt->execute()) {

    if ($novaImagemSalva && !empty($produto["imagem"])) {
        $arquivoAntigo = "uploads/" . basename($produto["imagem"]);

        if (is_file($arquivoAntigo)) {
            unlink($arquivoAntigo);
        }
    }

    header("Location: cardapio.php");
    exit;
}

if ($novaImagemSalva) {
    unlink("uploads/" . $novaImagemSalva);
}

die("Erro ao atualizar: " . $stmt->error);
?>