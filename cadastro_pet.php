<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Pet - Adoção de Pets</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container-cadastro {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        label {
            font-weight: bold;
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
    </style>
</head>
<body>
    <div class="container-cadastro">
        <h1>Cadastrar Pet</h1>
        <form action="auth.php" method="POST">
    <input type="hidden" name="acao" value="cadastrar_pet">

    <label for="nome">Nome do Pet:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="especie">Espécie:</label>
    <input type="text" id="especie" name="especie" required>

    <label for="idade">Idade:</label>
    <input type="number" id="idade" name="idade" required>

    <label for="porte">Porte:</label>
    <select id="porte" name="porte" required>
        <option value="pequeno">Pequeno</option>
        <option value="medio">Médio</option>
        <option value="grande">Grande</option>
    </select>

    <label for="sexo">Sexo:</label>
    <select id="sexo" name="sexo" required>
        <option value="macho">Macho</option>
        <option value="femea">Fêmea</option>
    </select>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="disponivel">Disponível</option>
        <option value="adotado">Adotado</option>
        <option value="perdido">Perdido</option>
        <option value="falecido">Falecido</option>
    </select>

    <button type="submit">Cadastrar Pet</button>
</form>


    </div>
</body>
</html>
