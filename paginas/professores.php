<h1>Professores</h1>
<?php

# Processa Itens Recebidos
if (isset($acao)) {
    if ($acao == "salvar") {
        if ($_POST['enviar-professor']) {
            $professor = new Professor();
            if (!empty($_POST['nome-professor'])) {
                $professor->setProfessor(
                    $_POST['codigo_professor'],
                    $_POST['nome-professor']
                );

                if ($professor->salvar()) {
                    $msg['msg'] = "Registro Salvo com sucesso!";
                    $msg['class'] = "success";
                } else {
                    $msg['msg'] = "Falha ao salvar Registro!";
                    $msg['class'] = "danger";
                }
            } else {
                $msg['msg'] = "Todos os atributos precisam ser preenchidos";
                $msg['class'] = "danger";
            }
            $_SESSION['msgs'][] = $msg;
            unset($professor);
        }
    } else if ($acao == "excluir") {
        if (isset($codigo)) {
            if (Professor::excluir($codigo)) {
                $msg['msg'] = "Registro excluido com sucesso!";
                $msg['class'] = "success";
            } else {
                $msg['msg'] = "Falha ao excluir Registro!";
                $msg['class'] = "danger";
            }
            $_SESSION['msgs'][] = $msg;
        }
    } else if ($acao == "editar") {
        if (isset($codigo)) {
            $professor = Professor::getProfessor($codigo);
        }
    }
}

# Exibe Mensagens
if (isset($_SESSION['msgs'])) {

    foreach ($_SESSION['msgs'] as $msg)
        echo "<div class='all-msgs alert alert-{$msg['class']}'>{$msg['msg']}</div>";

    echo "<script defer> 
            setTimeout(function() {
                document.querySelector('.all-msgs').style='display:none';
            }, 2000);
        </script>";

    unset($_SESSION['msgs']);
}


# Formulario e Tabela
if (!isset($professor)) {
    $professor = new Professor();
    $professor->setProfessor(null, null);
}
?>
<div class="container-fluid">
    <h2> Cadastro de professores</h2>
    <form name="form-professor" method="POST" action="<?php print $url_pagina ?>/salvar">
        <input type="hidden" name="codigo_professor" value="<?php echo $professor->getCodigo() ?>" />
        <div class="input-group mb-2">
            <span class="input-group-text">Nome do Professor:</span>
            <input type="text" class="form-control" id="nome-professor" name="nome-professor" value="<?php echo $professor->getNome() ?>">
        </div>
        <input type="submit" class="btn btn-primary" name="enviar-professor" value="Enviar" />
    </form>
    <hr />
</div>
<?php
# Listar registros existentes
?>
<div class="container-fluid">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Professor</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            # Lista os Professores
            $professores = Professor::listar();
            if (isset($professores)) {
                foreach ($professores as $professor) {
                    echo "<tr>
                        <td>{$professor->getCodigo()}</td>
                        <td>{$professor->getNome()}</td>
                        <td>
                            <span class='badge rounded-pill bg-primary'>
                                <a href='{$url_pagina}/editar/{$professor->getCodigo()}' style='color:#fff'><i class='bi bi-pencil-square'></i></a>
                            </span>
                            <span class='badge rounded-pill bg-danger'>
                                <a href='{$url_pagina}/excluir/{$professor->getCodigo()}'style='color:#fff'><i class='bi bi-trash'></i></a>
                            </span>
                        </td>
                        </tr>";
                }
            } else {
                echo "<p>Nenhum registro Desponível</p>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>