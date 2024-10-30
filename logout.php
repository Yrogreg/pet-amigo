<?php
session_start(); // Inicia a sessão

// Verifica se a sessão foi iniciada
if (isset($_SESSION['usuario_id'])) {
    session_unset(); // Limpa todas as variáveis de sessão
    session_destroy(); // Destroi a sessão ativa
}

// Redireciona para a página de login
header("Location: login.html");
exit();
?>
