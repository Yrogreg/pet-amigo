<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}
include 'conexao.php';

$filtro_especie = $_GET['especie'] ?? '';
$filtro_status = $_GET['status'] ?? '';

// Monta a consulta SQL com filtros
$sql = "SELECT * FROM pets WHERE 1=1";
if ($filtro_especie) {
    $sql .= " AND especie LIKE ?";
}
if ($filtro_status) {
    $sql .= " AND status = ?";
}

$stmt = $conn->prepare($sql);

if ($filtro_especie && $filtro_status) {
    $stmt->bind_param("ss", $filtro_especie, $filtro_status);
} elseif ($filtro_especie) {
    $stmt->bind_param("s", $filtro_especie);
} elseif ($filtro_status) {
    $stmt->bind_param("s", $filtro_status);
}

$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pets - Adoção de Pets</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f5;
            margin: 20px;
        }
        .container-pets {
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
        form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        input, select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .pet-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container-pets">
        <h1>Lista de Pets Disponíveis</h1>
        <form method="GET" action="lista_pets.php">
            <input type="text" name="especie" placeholder="Filtrar por espécie" value="<?php echo $filtro_especie; ?>">
            <select name="status">
                <option value="">Todos os Status</option>
                <option value="disponivel" <?php if ($filtro_status == 'disponivel') echo 'selected'; ?>>Disponível</option>
                <option value="adotado" <?php if ($filtro_status == 'adotado') echo 'selected'; ?>>Adotado</option>
                <option value="perdido" <?php if ($filtro_status == 'perdido') echo 'selected'; ?>>Perdido</option>
                <option value="falecido" <?php if ($filtro_status == 'falecido') echo 'selected'; ?>>Falecido</option>
            </select>
            <button type="submit">Filtrar</button>
        </form>

        <?php if ($resultado->num_rows > 0): ?>
            <?php while ($pet = $resultado->fetch_assoc()): ?>
                <div class="pet-card">
                    <h2><?php echo $pet['nome']; ?></h2>
                    <p>Espécie: <?php echo $pet['especie']; ?></p>
                    <p>Idade: <?php echo $pet['idade']; ?> anos</p>
                    <p>Status: <?php echo $pet['status']; ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhum pet encontrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
