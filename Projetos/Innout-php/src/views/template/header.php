<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In N' Out</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="assets/css/comum.css" rel="stylesheet"/>
    <link href="assets/css/icofont.min.css" rel="stylesheet"/>
    <link href="assets/css/template.css" rel="stylesheet"/>    
</head>
<body>
    <header class="header">
        <div class="logo">
            <i class="icofont-travelling mr-2 ml-2"></i>
            <span class="font-weight-light">In</span>
            <span class="font-weight-bold mr-2 ml-2">N'</span>
            <span class="font-weight-light">Out</span>
            <i class="icofont-runner-alt-1 ml-2"></i>
        </div>
        <div class="menu-toggle mx-3">
            <i class="icofont-navigation-menu"></i>
        </div>
        <div class="spacer"></div>
        <div class="dropdown">
            <div class="dropdown-button">
            <img  alt="user" class="avatar"
                src=<?= @"http://www.gravatar.com/avatar.php?gravatar_id=".md5(strtolower(trim($_SESSION['user']->email))) ?> />         
            <span class="ml-3"><?= @$_SESSION['user']->name ?></span>                         
                <i class="icofont-simple-down mx-2"></i>
                <div class="dropdown-content mb-3">
                    <ul class="nav-list mt-1">
                        <li class="nav-item">
                            <a href="logout.php" class="">
                                <i class="icofont-logout mr-2">Sair</i>
                            </a>                        
                        </li>                        
                    </ul>
                </div>                  
            </div>
        </div>
    </header>