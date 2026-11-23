<?php
/**
 * Retorna a URL da imagem de um produto, ou null se não houver imagem.
 *
 * Aceita dois formatos na coluna `imagem`:
 *  1) Nome/caminho de arquivo (ex.: "abc123.jpg" ou "uploads/abc123.jpg")
 *     -> devolve "uploads/abc123.jpg" se o arquivo existir na pasta.
 *  2) Conteúdo da imagem no próprio banco (BLOB ou base64)
 *     -> devolve "imagem.php?id=ID", que entrega a imagem com o tipo correto.
 */
function valorEhNomeDeArquivo($valor)
{
    if (!is_string($valor) || $valor === '' || strlen($valor) > 255) {
        return false;
    }
    if (strpos($valor, "\0") !== false) {
        return false;
    }
    return (bool) preg_match('/\.(jpe?g|png|webp|gif)$/i', trim($valor));
}

function urlImagemProduto($valorBanco, $idProduto = null)
{
    if ($valorBanco === null || $valorBanco === '') {
        return null;
    }

    // Caso 1: nome de arquivo guardado no banco
    if (valorEhNomeDeArquivo($valorBanco)) {
        $nomeArquivo = basename(str_replace('\\', '/', trim($valorBanco)));
        $pasta = __DIR__ . '/uploads/';

        if (is_file($pasta . $nomeArquivo)) {
            return 'uploads/' . rawurlencode($nomeArquivo);
        }

        // Diferença de maiúsculas/minúsculas entre banco e disco (comum no Linux)
        if (is_dir($pasta)) {
            foreach (scandir($pasta) as $arquivo) {
                if (strcasecmp($arquivo, $nomeArquivo) === 0 && is_file($pasta . $arquivo)) {
                    return 'uploads/' . rawurlencode($arquivo);
                }
            }
        }

        return null; // arquivo não existe na pasta uploads
    }

    // Caso 2: imagem gravada no banco (BLOB ou base64)
    if ($idProduto) {
        return 'imagem.php?id=' . (int) $idProduto;
    }

    return null;
}