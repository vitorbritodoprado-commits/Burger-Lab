<?php

$conexao = mysqli_connect(
    "localhost",
    "root",
    "root",
    "burgerlab"
);

if (!$conexao) {
    die("Erro na conexão: " . mysqli_connect_error());
}
