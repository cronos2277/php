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
            <tr>
                    <td>Horas trabalhadas</td>
                    <td><?= $sumOfWorkedTime; ?></td>                    
                    <td>Saldo Mensal</td>
                    <td><?= $balance; ?></td>
            </tr>
        </table>
            <form action="#" method="post" class="my-4">
                <select name="period" class="form-control ml-1" placeholder="Selecione um periodo">
                    <?php foreach($periods as $key => $month){
                        $selected = ($key == $_POST['period'])?'selected':'';
                        echo "<option value='{$key}' {$selected}>{$month}</option>";
                    } ?>
                </select>
            </form>    
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
                        <td><?= formatDateWithLocale($register->work_date,'%A, %d de %B de %Y'); ?></td>
                        <td><?= $register->time1; ?></td>
                        <td><?= $register->time2; ?></td>
                        <td><?= $register->time3; ?></td>
                        <td><?= $register->time4; ?></td>
                        <td><?= $register->getBalance(); ?></td>                        
                    </tr>
                <?php endforeach; ?>               
            </tbody>
        </table>
    </div>
</main>