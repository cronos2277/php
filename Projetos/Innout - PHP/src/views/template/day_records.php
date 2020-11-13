<main class="content">
    <?php renderTitle(
        "Registrar Ponto",
        " Mantenha o seu ponto consistente!",
        "icofont-check-alt"
        );
        include(TEMPLATE_PATH . "/messages.php");
    ?>
    <div class="card">
        <div class="card-header">
            <h3><?= $today ?></h3>
            <p class="mb-0">Os batimentos efetuados hoje</p>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-around m-5">
                <span class="record">Entrada 1:  <?= $workingHours->time1 ?? '---' ?></span>
                <span class="record">Saída 1: <?= $workingHours->time2 ?? '----'; ?></span>
            </div>
            <div class="d-flex justify-content-around m-5">
                <span class="record">Entrada 2: <?= $workingHours->time3 ?? '----'; ?></span>
                <span class="record">Saída 2: <?= $workingHours->time4 ?? '----'; ?></span>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-center">
            <a href="innout.php" class="btn btn-secondary btn-lg">
                <i class="icofont-check mr-1"></i>
                Bater o Ponto
            </a>
        </div>
    </div>
</main>
