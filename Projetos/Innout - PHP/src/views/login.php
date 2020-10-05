<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In N' Out</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="assets/css/comum.css" rel="stylesheet"/>
    <link href="assets/css/icofont.min.css" rel="stylesheet"/>
    <link href="assets/css/login.css" rel="stylesheet"/>
</head>
<body>
    <form action="#" method="post" class="form-login">
        <div class="login-card card">
            <div class="card-header">
                <i class="icofont-travelling mr-2"></i>
                <span class="font-weight-light">In</span>
                <span class="font-weight-bold mr-2 ml-2">N'</span>
                <span class="font-weight-light">Out</span>
                <i class="icofont-runner-alt-1 ml-2"></i>
            </div>
            <div class="card-body">
            <?php include(TEMPLATE_PATH.'/messages.php'); ?>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                        <input type="email" name="email" id="email" class="form-control <?= $errors['email'] ? 'is-invalid': '' ?>" 
                        value="<?php if(isset($email))echo $email; ?>" placeholder="Informe o e-mail" autofocus>
                    <div class="invalid-feedback">
                        <?= $errors['email']; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                        <input type="password" name="password" id="password" class="form-control <?= $errors['password'] ? 'is-invalid': '' ?>" 
                        placeholder="Informe o password">
                        <div class="invalid-feedback">
                        <?= $errors['password']; ?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-lg btn-primary">Entrar</button>
            </div>
        </div>
    </form>    
</body>
</html>