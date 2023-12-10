<?php

// Inclui o arquivo de configuração
require_once('config.php');

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario'])) {

    // Redireciona o usuário para a página de login
    header('Location: login.php');

}

// Obtém o tipo de conteúdo que está sendo gerenciado
$tipo = $_GET['tipo'];

// Verifica se o tipo de conteúdo é válido
if (!in_array($tipo, ['postagem', 'foto', 'banner'])) {

    // Exibe uma mensagem de erro
    echo 'Tipo de conteúdo inválido.';

}

// Conecta ao banco de dados
$db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

// Seleciona o conteúdo
$stmt = $db->prepare('SELECT * FROM ' . $tipo . ' ORDER BY id DESC');
$stmt->execute();

// Exibe a lista de conteúdo
?>

<table class="tabela-conteudo">

    <thead>
    <tr>
        <th>Título</th>
        <th>Data</th>
        <th>Ações</th>
    </tr>
    </thead>

    <tbody>

    <?php while ($conteudo = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>

        <tr>
            <td><?php echo $conteudo['titulo']; ?></td>
            <td><?php echo $conteudo['data']; ?></td>
            <td>
                <a href="editar-<?php echo $tipo; ?>.php?id=<?php echo $conteudo['id']; ?>">Editar</a>
                <a href="excluir-<?php echo $tipo; ?>.php?id=<?php echo $conteudo['id']; ?>">Excluir</a>
            </td>
        </tr>

    <?php } ?>

    </tbody>

</table>

<?php

// Se o usuário clicou no botão "Novo", abre o formulário de criação
if (isset($_GET['novo'])) {

    // Exibe o formulário de criação
    ?>

    <form action="criar-<?php echo $tipo; ?>.php" method="post">

        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo">

        <label for="conteudo">Conteúdo</label>
        <textarea name="conteudo" id="conteudo"></textarea>

        <button type="submit">Salvar</button>

    </form>

    <?php

}

?>
