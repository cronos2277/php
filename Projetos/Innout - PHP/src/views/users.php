<main class="content">
    <?php
        renderTitle(
            'Cadastro de Usuários',
            'Mantenha os dados dos usuários atualizados',
            'icofont-users'
        );
        include(TEMPLATE_PATH."/messages.php");
    ?>
    <a class="btn btn-lg btn-dark mb-3" href="save_user.php">Novo Usuário</a>
    <table class="table table-bordered table-striped">
        <thead>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Admissão</th>
            <th>Desligamento</th>
            <th>Ações</th>
        </thead>
        <tbody>
            <?php foreach($users as $user):?>
                <tr>
                    <td><?= $user->name; ?></td>
                    <td><?= $user->email; ?></td>
                    <td><?= $user->start_date; ?></td>
                    <td><?= $user->end_date; ?></td>
                    <td>
                        <a href="save_user.php?update=<?= $user->id ?>" class="ml-4 btn btn-dark rounded-circle mr-4">
                            <i class="icofont-edit"></i>
                        </a>
                        <a href="?delete=<?= $user->id ?>" class="btn btn-dark rounded-circle">
                            <i class="icofont-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>