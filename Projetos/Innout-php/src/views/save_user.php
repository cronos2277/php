<main class="content">
    <?php
        renderTitle(
            'Cadastro de Usuário',
            'Crie e atualize o usuário',
            'icofont-user'
        );
        include(TEMPLATE_PATH."/messages.php");        
    ?>
    <form action="#" method="post">
        <?php if(isset($id) && !empty($id)): ?>
            <input type="hidden" name="id" value="<?= $id ?>" />
        <?php endif; ?>
        <div class="form-row">
            <div class="form-group col-md-6 col-xs-12">
                <label for="name">NOME</label>
                <input id="name" type="text" name="name" placeholder="informe o nome" class="form-control 
                    <?= $errors['name'] ? 'is-invalid':''; ?>" value="<?= @$userData['name']; ?>">
            </div>            
            <div class="form-group col-md-6 col-xs-12">
                <label for="email">E-MAIL</label>
                <input id="email" type="email" name="email" placeholder="Informe o e-mail" class="form-control 
                    <?= $errors['email'] ? 'is-invalid':''; ?>" value="<?= @$userData['email']; ?>">
            </div>            
        </div>
        <div class="form-row">
            <div class="form-group col-md-6 col-xs-12">
                <label for="password">SENHA</label>
                <input id="password" type="password" name="password" placeholder="informe a senha" class="form-control
                    <?= $errors['password'] ? 'is-invalid':''; ?>">
            </div>            
            <div class="form-group col-md-6 col-xs-12">
                <label for="confirm_password">CONFIRME SENHA</label>
                <input id="confirm_password" type="password" name="confirm_password" placeholder="Confirme a senha" 
                    class="form-control <?= $errors['confirm_password'] ? 'is-invalid':''; ?>">
            </div>            
        </div>
        <div class="form-row">
            <div class="form-group col-md-6 col-xs-12">
                <label for="start_date">DATA DE INÍCIO</label>
                <input id="start_date" type="date" name="start_date" class="form-control <?= $errors['start_date'] ? 'is-invalid':''; ?>" value="<?= @$userData['start_date']; ?>">
            </div>            
            <div class="form-group col-md-6 col-xs-12">
                <label for="end_date">DATA DE DESLIGAMENTO</label>
                <input id="end_date" type="date" name="end_date"  class="form-control <?= $errors['end_date'] ? 'is-invalid':''; ?>" value="<?= @$userData['end_date']; ?>">
            </div>            
        </div>
        <div class="form-row">
            <div class="form-group">
                <input type="checkbox" name="is_admin" id="is_admin" <?= @$errors['is_admin'] ? 'is-invalid':''; ?> <?= @$is_admin ? "checked":''?>>
                <label for="is_admin">Adminstrador?</label>
            </div>            
        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-dark">Salvar</button>
            <a href="/users.php" class="btn btn-lg btn-secondary">Cancelar</a>
        </div>
        <div class="invalid-feedback" style="display:block">
                <?= @$errors['name'] ?>
                <br />
                <?= @$errors['email'] ?>
                <br />
                <?= @$errors['password']; ?>
                <br />
                <?= @$errors['confirm_password'] ?>
                <br />
                <?= @$errors['start_date'] ?>
                <br />
                <?= @$errors['end_date'] ?>
                <br />
                <?= @$errors['is_admin'] ?>
            </div>
    </form>
</main>