<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: adicionar_produtos.php");
    exit;
}

$nome = trim($_POST["nome"] ?? "");
$descricao = trim($_POST["descricao"] ?? "");
$preco = $_POST["preco"] ?? "";
$categoria = trim($_POST["categoria"] ?? "");

if ($nome === "" || !is_numeric($preco) || $preco < 0) {
    die("Preencha os campos corretamente.");
}

$imagem = null;

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

    $imagem = bin2hex(random_bytes(16)) . "." . $permitidos[$tipo];

    if (
        !move_uploaded_file(
            $_FILES["imagem"]["tmp_name"],
            "uploads/" . $imagem
        )
    ) {
        die("Erro ao salvar imagem.");
    }
}

$sql = "INSERT INTO produtos
        (nome, descricao, preco, categoria, imagem)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ssdss",
    $nome,
    $descricao,
    $preco,
    $categoria,
    $imagem
);

if ($stmt->execute()) {
    header("Location: cardapio.php");
    exit;
}

die("Erro ao cadastrar produto: " . $stmt->error);
?>