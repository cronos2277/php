<main class="content">
    <?php
        renderTitle(
            'Relatório Gerencial',
            'Resumo das horas trabalhadas dos funcionários',
            'icofont-chart-histogram'
        );
    ?>
    <div class="summary-boxes">
        <div class="summary-box bg-dark">
            <i class="icon icofont-users text-white"></i>
                <p class="title text-white">Quantidade de funcionários</p>
                <h3 class="value text-white"><?= $activeUsersCount; ?></h3>
        </div>
        <div class="summary-box bg-dark">
            <i class="icon icofont-patient-bed text-white"></i>
                <p class="title text-white">Quantidades de faltas</p>
                <h3 class="value text-white"><?= count($absentUsers); ?></h3>
        </div>
        <div class="summary-box bg-dark">
            <i class="icon icofont-sand-clock text-white"></i>
                <p class="title text-white">Horas trabalhadas no Mês</p>
                <h3 class="value text-white"><?= $hoursInMonth; ?></h3>
        </div>
    </div>
    <?php if(count($absentUsers) > 0): ?>
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title"> Faltosos do dia </h4>
                <p class="card-category mb-0">Relação dos funcionários que ainda não bateram o ponto.</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>Nome</th>
                    </thead>                
                    <tbody>
                        <?php foreach($absentUsers as $name): ?>
                            <tr>
                                <td><?= $name ?></td>
                            </tr>
                        <?php endforeach; ?>    
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</main>