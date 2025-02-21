<?php
session_start(); // Inicia a sessão

// Configuração da conexão com o banco de dados
$host = 'localhost';
$dbname = 'educacional';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Processamento do login (quando o formulário for enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $senha = trim($_POST['senha']);

    // Preparar SQL para buscar o usuário
    $sql = "SELECT * FROM usuarios WHERE login = :usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();

    $usuario_bd = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se o usuário existe e a senha está correta
    if ($usuario_bd && password_verify($senha, $usuario_bd['senha'])) {
        $_SESSION['usuario_id'] = $usuario_bd['id'];
        $_SESSION['usuario_nome'] = $usuario_bd['nome'];
        header("Location: home.html"); // Redireciona para a página inicial
        exit;
    } else {
        $_SESSION['erro_login'] = 'Usuário ou senha inválidos.';
        header("Location: index.php"); // Redireciona de volta para a página de login
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/ptcc/images/icons/icone.ico">
    <link rel="stylesheet" href="css/style.css">
    <title>Login - Website Educacional</title>
</head>

<body>

    <main id="container">
        <h1 id="titulo">Website Educacional</h1>

        <form action="index.php" method="POST">
            <div class="input-field">
                <label for="usuario">Login:</label>
                <input type="text" name="usuario" id="usuario" class="form-control" title="Digite aqui seu usuário para acessar o Ambiente" required>
            </div>
            <div class="input-field">
                <div>
                    <label for="senha">Senha:</label>
                    <a href="#" id="esqueci_senha">Esqueceu a senha?</a>
                </div>
                <input type="password" name="senha" id="senha" class="form-control" title="Digite aqui sua senha" required>
            </div>

            <button type="submit" id="bt_entrar">Entrar</button>
        </form>

        <?php if (isset($_SESSION['erro_login'])): ?>
            <p><?php echo $_SESSION['erro_login'];
                unset($_SESSION['erro_login']); ?></p>
        <?php endif; ?>

        <div id="validacao">
            <a href="validacao.php">Deseja validar os documentos?</a>
        </div>

        <div id="validacao">
            <a href="cadastro.php">Não tem cadastro?</a>
        </div>

    </main>

</body>

</html>