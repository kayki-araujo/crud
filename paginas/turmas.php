<h1>Turmas</h1>
<?php

#processar informações recebidas
if (isset($acao)) {
    if ($acao == "salvar") {
        if ($_POST['enviar-turma']) {
            $turma = new Turma();
            $professor = new Professor();
            if (!empty($_POST['nome-turma']) && !empty($_POST['curso-turma']) && !empty($_POST['codigo-professor-turma'])) {
                $professor->setProfessor($_POST['codigo-professor-turma'], null);

                $turma->setTurma(
                    $_POST['codigo_turma'],
                    $_POST['curso-turma'],
                    $_POST['nome-turma'],
                    $professor
                );

                if ($turma->salvar()) {
                    $msg['msg'] = "Registro Salvo com sucesso!";
                    $msg['class'] = "success";
                } else {
                    $msg['msg'] = "Falha ao Salvar Registro!";
                    $msg['class'] = "danger";
                }
            } else {
                $msg['msg'] = "Todos os atributos precisam ser preenchidos";
                $msg['class'] = "danger";
            }

            $_SESSION['msgs'][] = $msg;
            unset($turma);
        }
    } else if ($acao == "excluir") {
        if (isset($codigo)) {
            if (Turma::excluir($codigo)) {
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
            $turma = Turma::getTurma($codigo);
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



#exibir o formulário de cadastro
if (!isset($turma)) {
    $turma = new Turma();
    $turma->setTurma(null, null, null, new Professor());
}
?>
<div class="container-fluid">
    <h2> Cadastro de turmas</h2>
    <form name="form-turma" method="POST" action="<?php print $url_pagina ?>/salvar">
        <input type="hidden" name="codigo_turma" value="<?php echo $turma->getCodigo() ?>" />
        <div class="input-group mb-2 mb-2">
            <label class="input-group-text" for="inputGroupCurso">Curso</label>
            <select class="form-select" name="curso-turma">
                <option value="<?php echo $turma->getCurso() ?>"><?php echo $turma->getCurso() ?></option>
                <option value="Informática">Informática</option>
                <option value="Eletronica">Eletrônica</option>
                <option value="Eletrotécnica">Eletrotécnica</option>
                <option value="Macânica">Mecânica</option>
            </select>
        </div>
        <div class="input-group mb-2">
            <span class="input-group-text">Nome da Turma:</span>
            <input type="text" class="form-control" id="nome-turma" name="nome-turma" value="<?php echo $turma->getNome() ?>">
        </div>
        <div class="input-group mb-2 mb-2">
            <label class="input-group-text" for="inputGroupProfessor">Professor</label>
            <select class="form-select" name="codigo-professor-turma">
                <option value="<?php echo $turma->getProfessor()->getCodigo()  ?>"><?php echo $turma->getProfessor()->getNome()  ?></option>
                <?php
                $professores = Professor::listar();
                if ($professores) {
                    $semProfessores = false;
                    foreach ($professores as $item) {
                        echo "<option value='{$item->getCodigo()}'>{$item->getNome()}</option>";
                    }
                } else {
                    $semProfessores = true;
                }
                ?>
            </select>
        </div>
        <input type="submit" class="btn btn-primary" name="enviar-turma" value="Enviar" <?php if ($semProfessores) print "disabled" ?> />

    </form>
    <hr />
</div>
<?php
#listar registros existentes
?>
<div class="container-fluid">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Turma</th>
                <th scope="col">Curso</th>
                <th scope="col">Professor</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            #Busca lista de turmas
            $turmas = Turma::listar();
            if (isset($turmas)) {
                foreach ($turmas as $turma) {
                    echo "<tr>
                        <td>{$turma->getCodigo()}</td>
                        <td>{$turma->getNome()}</td>
                        <td>{$turma->getCurso()}</td>
                        <td>{$turma->getProfessor()->getNome()}</td>
                        <td>
                            <span class='badge rounded-pill bg-primary'>
                                <a href='{$url_pagina}/editar/{$turma->getCodigo()}' style='color:#fff'><i class='bi bi-pencil-square'></i></a>
                            </span>
                            <span class='badge rounded-pill bg-danger'>
                                <a href='{$url_pagina}/excluir/{$turma->getCodigo()}'style='color:#fff'><i class='bi bi-trash'></i></a>
                            </span>
                        </td>
                        </tr>
                    ";
                }
            } else {
                echo "<p>Nenhum registro Desponível</p>";
            }
            ?>
        </tbody>
    </table>
</div>