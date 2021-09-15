<h1>Alunos</h1>
<?php

#Acao

if (isset($acao)) {
    if ($acao == "salvar") {
        if ($_POST['enviar-aluno']) {
            $aluno = new Aluno();
            $turma = new Turma();

            if (!empty($_POST['nome-aluno']) && !empty($_POST['matricula-aluno']) && !empty($_POST['codigo-turma-aluno'])) {
                $turma->setTurma($_POST['codigo-turma-aluno'], null, null, null);

                $aluno->setAluno(
                    $_POST['codigo_aluno'],
                    $_POST['nome-aluno'],
                    $_POST['matricula-aluno'],
                    $turma
                );

                if ($aluno->salvar()) {
                    $msg['msg'] = "Registro Salvo com sucesso!";
                    $msg['class'] = "success";
                } else {
                    $msg['msg'] = "Falha ao salvar Registro!";
                    $msg['class'] = "danger";
                }
            } else {
                $msg['msg'] = "Todos os atributos precisam ser preenchidos!";
                $msg['class'] = "danger";
            }

            $_SESSION['msgs'][] = $msg;
            unset($aluno);
        }
    } else if ($acao == "excluir") {
        if (isset($codigo)) {
            if (Aluno::excluir($codigo)) {
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
            $aluno = Aluno::getAluno($codigo);
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
if (!isset($aluno)) {
    $aluno = new Aluno();
    $aluno->setAluno(null, null, null, new Turma());
}
?>
<!-- Formulário -->
<div class="container-fluid">
    <h2> Cadastro de Alunos</h2>
    <form name="form-aluno" method="POST" action="<?php print $url_pagina ?>/salvar">
        <input type="hidden" name="codigo_aluno" value="<?php echo $aluno->getCodigo() ?>" />
        <div class="input-group mb-2">
            <span class="input-group-text">Nome do Aluno:</span>
            <input type="text" class="form-control" id="nome-aluno" name="nome-aluno" value="<?php echo $aluno->getNome() ?>">
        </div>
        <div class="input-group mb-2">
            <span class="input-group-text">Matrícula:</span>
            <input type="number" class="form-control" id="matricula-aluno" name="matricula-aluno" value="<?php echo $aluno->getMatricula() ?>">
        </div>
        <div class="input-group mb-2 mb-2">
            <label class="input-group-text" for="inputGroupTurma">Turma</label>
            <select class="form-select" name="codigo-turma-aluno">
                <option value="<?php echo $aluno->getTurma()->getCodigo()  ?>"><?php echo $aluno->getTurma()->getNome() ?></option>

                <?php

                $turma = new Turma();
                $turmas = Turma::listar();


                if ($turmas) {
                    $semTurmas = false;
                    foreach ($turmas as $item) {
                        echo "<option value='{$item->getCodigo()}'>{$item->getNome()}</option>";
                    }
                } else {
                    $semTurmas = true;
                }
                ?>
            </select>
        </div>
        <input type="submit" class="btn btn-primary" name="enviar-aluno" value="Enviar" <?php if ($semTurmas) print "disabled" ?> />

    </form>
    <hr />
</div>

<!-- Tabela -->
<div class="container-fluid">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Aluno</th>
                <th scope="col">Matricula</th>
                <th scope="col">Turma</th>
                <th scope="col">Professor</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            #Busca lista de alunos
            $alunos = Aluno::listar();
            if (isset($alunos)) {
                foreach ($alunos as $item) {
                    echo "<tr>
                        <td>{$item->getCodigo()}</td>
                        <td>{$item->getNome()}</td>
                        <td>{$item->getMatricula()}</td>
                        <td>{$item->getTurma()->getNome()}</td>
                        <td>{$item->getTurma()->getProfessor()->getNome()}</td>
                        <td>
                            <span class='badge rounded-pill bg-primary'>
                                <a href='{$url_pagina}/editar/{$item->getCodigo()}' style='color:#fff'><i class='bi bi-pencil-square'></i></a>
                            </span>
                            <span class='badge rounded-pill bg-danger'>
                                <a href='{$url_pagina}/excluir/{$item->getCodigo()}'style='color:#fff'><i class='bi bi-trash'></i></a>
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