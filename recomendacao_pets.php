<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'adotante') {
    header("Location: login.html");
    exit();
}
include 'conexao.php';

// Recupera as preferências do adotante logado
$usuario_id = $_SESSION['usuario_id'];
$sql_preferencias = "SELECT especie, porte, sexo FROM preferencias WHERE usuario_id = ?";
$stmt = $conn->prepare($sql_preferencias);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$preferencias = $resultado->fetch_assoc();

$especie = $preferencias['especie'] ?? '';
$porte = $preferencias['porte'] ?? '';
$sexo = $preferencias['sexo'] ?? '';

// Consulta para buscar pets compatíveis com as preferências
$sql_pets = "SELECT * FROM pets WHERE status = 'disponivel' AND 
             (especie = ? OR ? = '') AND 
             (porte = ? OR ? = '') AND 
             (sexo = ? OR ? = '')";
$stmt_pets = $conn->prepare($sql_pets);
$stmt_pets->bind_param("ssssss", $especie, $especie, $porte, $porte, $sexo, $sexo);
$stmt_pets->execute();
$resultado_pets = $stmt_pets->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recomendação de Pets Compatíveis</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container-recomendacao {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 80%;
            max-width: 800px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .pet-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .pet-card h2 {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container-recomendacao">
        <h1>Pets Compatíveis</h1>

        <?php if ($resultado_pets->num_rows > 0): ?>
            <?php while ($pet = $resultado_pets->fetch_assoc()): ?>
                <div class="pet-card">
                    <h2><?php echo $pet['nome']; ?></h2>
                    <p>Espécie: <?php echo $pet['especie']; ?></p>
                    <p>Porte: <?php echo ucfirst($pet['porte']); ?></p>
                    <p>Sexo: <?php echo ucfirst($pet['sexo']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhum pet compatível encontrado.</p>
        <?php endif; ?>

        <a href="dashboard.php">Voltar ao Dashboard</a>
    </div>
</body>
</html>
