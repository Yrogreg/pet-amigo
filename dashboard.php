<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html"); // Redireciona para login se não estiver logado
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Adoção de Pets</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f0f0f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container-dashboard {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 80%;
            max-width: 800px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .links-dashboard {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }

        .link {
            background-color: #4CAF50;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .link:hover {
            background-color: #45a049;
        }

        @media (max-width: 500px) {
            .link {
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container-dashboard">
        <h2>Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?>!</h2>
        <div class="links-dashboard">
            <a href="lista_pets.php" class="link">Lista de Pets</a>
            
            <?php if ($_SESSION['usuario_tipo'] === 'tutor'): ?>
                <a href="cadastro_pet.php" class="link">Cadastrar Pet</a>
                <a href="acompanhamento.php" class="link">Acompanhar Adoção</a>
                <a href="relatorio_acompanhamento.php" class="link">Relatório de Acompanhamento</a>
            <?php endif; ?>

            <?php if ($_SESSION['usuario_tipo'] === 'adotante'): ?>
                <a href="recomendacao_pets.php" class="link">Ver Pets Compatíveis</a>
            <?php endif; ?>

            <a href="perfil.php" class="link">Perfil</a>
            <a href="logout.php" class="link">Sair</a>
        </div>
    </div>
</body>
</html>
