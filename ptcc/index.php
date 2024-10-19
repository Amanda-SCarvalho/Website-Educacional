<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css\style.css">

    <title>Website Educacional</title>
</head>

<body>

    <header>
        <img src="images\icons\logo.png" id="logo">
    </header>

    <main id="container">
        <h1 id="titulo">
            Website Educacional
        </h1>

        <form action="home.html">
            <div class="input-field">
                <label for="usuario">
                    Login:
                </label>
                <input type="text" name="usuario" id="usuario" class="form-control" title="Digite aqui seu usuário para acessar o Ambiente">
            </div>
            <div class="input-field">
                <div>
                    <label for="senha">
                        Senha:
                    </label>

                    <a href="#" id="esqueci_senha">
                        Esqueceu a senha?
                    </a>

                </div>

                <input type="password" name="senha" id="senha" class="form-control" title="Digite aqui sua senha">
            </div>

            <button type="submit" id="bt_entrar">
                Entrar
            </button>

            

        </form>

        <div id="validacao">
                <a href="#">
                    Deseja validar os documentos?
                </a>
            </div>

    </main>

</body>

</html>