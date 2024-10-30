<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}
include 'conexao.php';

// Consulta para buscar dados do usuário logado
$usuario_id = $_SESSION['usuario_id'];
$sql_usuario = "SELECT nome, email, tipo FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql_usuario);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <style>
        body {
            background-color: #f0f0f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .container-perfil {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 80%;
            max-width: 400px;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input, select {
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

        a {
            margin-top: 20px;
            display: block;
            text-decoration: none;
            color: #4CAF50;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container-perfil">
        <h1>Perfil de <?php echo $usuario['nome']; ?></h1>
        <p><strong>Email:</strong> <?php echo $usuario['email']; ?></p>
        <p><strong>Tipo:</strong> <?php echo ucfirst($usuario['tipo']); ?></p>

        <?php if ($usuario['tipo'] === 'adotante'): ?>
            <h2>Preferências de Adoção</h2>
            <form action="auth.php" method="POST">
                <input type="hidden" name="acao" value="salvar_preferencias">

                <label for="especie">Espécie:</label>
                <input type="text" id="especie" name="especie" placeholder="Ex: Cachorro, Gato">

                <label for="porte">Porte:</label>
                <input type="text" id="porte" name="porte" placeholder="Ex: Pequeno, Médio, Grande">

                <label for="sexo">Sexo:</label>
                <select id="sexo" name="sexo">
                    <option value="macho">Macho</option>
                    <option value="femea">Fêmea</option>
                </select>

                <button type="submit">Salvar Preferências</button>
            </form>
        <?php endif; ?>

        <a href="dashboard.php">Voltar ao Dashboard</a>
    </div>
</body>
</html>
