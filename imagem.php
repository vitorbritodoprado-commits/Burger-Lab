<?php
// Entrega a imagem de um produto que está gravada dentro do MySQL (BLOB ou base64).
// Uso: imagem.php?id=5
require_once "conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    http_response_code(400);
    exit;
}

$stmt = $conexao->prepare("SELECT imagem FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$linha = $stmt->get_result()->fetch_assoc();

if (!$linha || $linha["imagem"] === null || $linha["imagem"] === "") {
    http_response_code(404);
    exit;
}

$dados = $linha["imagem"];

// Se estiver em base64 (texto), converte para binário
if (strncmp($dados, "data:image", 10) === 0) {
    $pos = strpos($dados, "base64,");
    if ($pos !== false) {
        $dados = base64_decode(substr($dados, $pos + 7), true);
    }
} elseif (preg_match('/^[A-Za-z0-9+\/=\r\n]+$/', $dados) && strlen($dados) > 100) {
    $decodificado = base64_decode($dados, true);
    if ($decodificado !== false) {
        $dados = $decodificado;
    }
}

if ($dados === false || $dados === "") {
    http_response_code(404);
    exit;
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$tipo = $finfo->buffer($dados);

$permitidos = ["image/jpeg", "image/png", "image/webp", "image/gif"];

if (!in_array($tipo, $permitidos, true)) {
    http_response_code(415);
    exit;
}

// Limpa qualquer saída anterior (espaços/BOM) que corromperia a imagem
while (ob_get_level() > 0) {
    ob_end_clean();
}

header("Content-Type: " . $tipo);
header("Content-Length: " . strlen($dados));
header("Cache-Control: public, max-age=86400");

echo $dados;
exit;