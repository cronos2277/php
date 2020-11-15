<main class="content">
    <?php 
        renderTitle(
            'Relatório Mensal',
            'Acompanhe o seu saldo de horas',
            'icofont-ui-calendar'
        );
    ?>
    <div>
        <table class="table table-striped table-hover">
            <thead class="bg-dark text-white">
                <th>Dia</th>
                <th>Entrada 1</th>
                <th>Saída 1</th>
                <th>Entrada 2</th>
                <th>Saída 2</th>
                <th>saldo</th>
            </thead>
            <tbody>
                <?php foreach($report as $register): ?>
                    <tr>
                        <td><?= $register->work_date; ?></td>
                        <td><?= $register->time1; ?></td>
                        <td><?= $register->time2; ?></td>
                        <td><?= $register->time3; ?></td>
                        <td><?= $register->time4; ?></td>
                        <td>Saldo</td>                        
                    </tr>
                <?php endforeach; ?>
                <tr class="bg-dark text-white">
                    <td>Horas trabalhadas</td>
                    <td colspan="3"><?= $sumOfWorkedTime; ?></td>
                    <td>Saldo Mensal</td>
                    <td><?= $balance; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</main>