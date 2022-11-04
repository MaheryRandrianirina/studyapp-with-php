<?php

use Core\Helpers\MyDateTime;

 if(empty($results)): ?>
    <h1 class="empty-revision">Vous n'avez pas de revision pour aujourd'hui !</h1>

<?php else: ?>
    <?php $i = 0; ?>
    <?php $datetime = new MyDateTime(); ?>
    <?php foreach($results as $result):?>
    <?php $i++; ?>
        <?php if($result->getDone() === 0):?>
        <div class="subject subject-<?=$i?>">
            <p class="subject-name"><?=$result->getSubject()?></p>
            <div class="play"><i class="fas fa-play revision-button revision-play"></i></div>
            <p class="heure-revision <?= $result->getTime() < time() ? "time-left" : ""?>"><?= $result->getTime() > time() ? $datetime->getTime($result->getTime()) : "L'heure est déjà dépassée \n depuis " . $datetime->getTimeLeft($result->getTime())?></p>
        </div>
        <button class="another-time-revision-button button-<?=$i?>">Remettre la revision à plutard <i class="fas fa-edit"></i></button>
        <div class="subject-id" hidden><?=$result->getId()?></div>
        <div class="calendar-id" hidden><?=$result->getCalendarId()?></div>
        <div class="current-time" hidden><?=$result->getTime()?></div>
        <?php endif?>
    <?php endforeach?>
<?php endif?>
