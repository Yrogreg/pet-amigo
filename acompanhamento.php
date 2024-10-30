<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}
include 'conexao.php';

// Buscar pets adotados
$sql = "SELECT id, nome FROM pets WHERE status = 'adotado'";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acompanhamento Pós-Adoção</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container-acompanhamento {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        select, input, textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container-acompanhamento">
        <h1>Registrar Acompanhamento</h1>
        <form action="auth.php" method="POST">
            <input type="hidden" name="acao" value="acompanhamento">

            <label for="pet_id">Pet:</label>
            <select id="pet_id" name="pet_id" required>
                <?php while ($pet = $resultado->fetch_assoc()): ?>
                    <option value="<?php echo $pet['id']; ?>"><?php echo $pet['nome']; ?></option>
                <?php endwhile; ?>
            </select>

            <label for="data">Data da Visita:</label>
            <input type="date" id="data" name="data" required>

            <label for="observacao">Observação:</label>
            <textarea id="observacao" name="observacao"></textarea>

            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>
