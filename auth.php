<?php
session_start();
include 'conexao.php'; // Conecta ao banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Cadastro de usuário
    if (isset($_POST['acao']) && $_POST['acao'] == 'cadastrar') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografar senha
        $tipo = $_POST['tipo'];

        $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nome, $email, $senha, $tipo);

        if ($stmt->execute()) {
            echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='login.html';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar: " . $stmt->error . "'); window.location.href='cadastro.html';</script>";
        }
    }

    // Cadastro de pet
    elseif (isset($_POST['acao']) && $_POST['acao'] == 'cadastrar_pet') {
        $nome = $_POST['nome'];
        $especie = $_POST['especie'];
        $idade = $_POST['idade'];
        $porte = $_POST['porte'];
        $sexo = $_POST['sexo'];
        $status = $_POST['status'];

        $sql = "INSERT INTO pets (nome, especie, idade, porte, sexo, status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisss", $nome, $especie, $idade, $porte, $sexo, $status);

        if ($stmt->execute()) {
            echo "<script>alert('Pet cadastrado com sucesso!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar pet: " . $stmt->error . "'); window.location.href='cadastro_pet.php';</script>";
        }
    }

    // Registro de acompanhamento
    elseif (isset($_POST['acao']) && $_POST['acao'] == 'acompanhamento') {
        $pet_id = $_POST['pet_id'];
        $data = $_POST['data'];
        $observacao = $_POST['observacao'];

        $sql = "INSERT INTO acompanhamentos (pet_id, data, observacao) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $pet_id, $data, $observacao);

        if ($stmt->execute()) {
            echo "<script>alert('Acompanhamento registrado com sucesso!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Erro ao registrar acompanhamento: " . $stmt->error . "'); window.location.href='acompanhamento.php';</script>";
        }
    }

    // Salvamento de preferências de adoção
    elseif (isset($_POST['acao']) && $_POST['acao'] == 'salvar_preferencias') {
        $especie = $_POST['especie'] ?? '';
        $porte = $_POST['porte'] ?? '';
        $sexo = $_POST['sexo'] ?? '';
        $usuario_id = $_SESSION['usuario_id'];

        $sql = "INSERT INTO preferencias (usuario_id, especie, porte, sexo) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("isss", $usuario_id, $especie, $porte, $sexo);
            if ($stmt->execute()) {
                echo "<script>alert('Preferências salvas com sucesso!'); window.location.href='dashboard.php';</script>";
            } else {
                echo "<script>alert('Erro ao salvar preferências: " . $stmt->error . "'); window.location.href='perfil.php';</script>";
            }
        } else {
            echo "<script>alert('Erro ao preparar consulta.'); window.location.href='perfil.php';</script>";
        }
    }

    // Login de usuário
    else {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();

        if ($usuario) {
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_tipo'] = $usuario['tipo'];
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<script>alert('Senha incorreta!'); window.location.href='login.html';</script>";
            }
        } else {
            echo "<script>alert('Email não encontrado!'); window.location.href='login.html';</script>";
        }
    }
}
?>
