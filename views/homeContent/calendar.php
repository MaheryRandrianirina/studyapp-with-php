<table class="calendar">
    <thead>
        <tr>
            <th>Matière <i class="fas fa-book"></i></th>
            <th>Date <i class="fas fa-calendar-day"></i></th>
            <th>Heure <i class="fas fa-calendar-times"></i></th>
            <th>Chapitre</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody class="calendar-tbody">
        <?php
        use Core\Helpers\MyDateTime;
        $datetime = new MyDateTime();
        foreach($results as $result):?> <!--boucle ray fotsiny ty aveo fa teto mbola maro2 ny EDT-->
            <?php foreach($result as $r):?>
                <tr>
                    <td><?=$r->getSubject()?></td>
                    <td class="subject-date"><?=$datetime->getDate($r->getDate())?></td>
                    <td><?= (int)$r->getTime() > time() ? $datetime->getTime($r->getTime()) : "L'heure est déjà dépassé"?></td>
                    <td><?=$r->getChapter()?></td>
                    <td class="status"><?= $r->getDone() === 0 ? 'pas encore fait' : 'terminé'?></td>
                </tr>
            <?php endforeach?>
        <?php endforeach?>
    </tbody>
</table>