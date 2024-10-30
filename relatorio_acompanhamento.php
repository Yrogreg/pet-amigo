<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}
include 'conexao.php';

// Consulta para buscar os acompanhamentos e os nomes dos pets
$sql = "SELECT a.id, p.nome AS nome_pet, a.data, a.observacao 
        FROM acompanhamentos a 
        JOIN pets p ON a.pet_id = p.id";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Acompanhamento</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f5;
            margin: 20px;
        }

        .container-relatorio {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-relatorio">
        <h1>Relatório de Acompanhamento</h1>
        <?php if ($resultado->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Pet</th>
                    <th>Data</th>
                    <th>Observação</th>
                </tr>
                <?php while ($acompanhamento = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $acompanhamento['nome_pet']; ?></td>
                        <td><?php echo $acompanhamento['data']; ?></td>
                        <td><?php echo $acompanhamento['observacao']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Nenhum acompanhamento registrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
