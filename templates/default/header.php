<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <script src="https://kit.fontawesome.com/c25320d901.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo URL_TEMPLATE ?>/css/style.css">

    <title>Escola</title>
</head>

<body>
    <header>
        <h1>Escola</h1>
        <input type="checkbox" name="menu-tgl" class="menu-tgl" id="menu-tgl">
        <nav>
            <ul>
                <li><a href="<?php print URL_HOME ?>/professores">Professores</a></li>
                <li><a href="<?php print URL_HOME ?>/turmas">Turmas</a></li>
                <li><a href="<?php print URL_HOME ?>/alunos">Alunos</a></li>
            </ul>
        </nav>
        <label for="menu-tgl" class="menu">
            <i class="fas fa-bars"></i>
        </label>
    </header>
    <main>