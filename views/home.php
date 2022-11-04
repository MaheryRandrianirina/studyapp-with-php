<?php

use App\Controllers\SubjectController;
use Core\Helpers\ImageHelper;
use Core\Helpers\viewHelper;
use src\helpers\DateHelper;

$home_class = "home";
$title = "home";
$js = "./assets/home.78b844fa2b455626c4fd.js";

?>
<section id="home-main">
    <div class="sidebar-left">
        <i class="fas fa-home revision-logo active-item" data-name="Révisions de <br> la journée"></i>
        <i class="fas fa-calendar calendar-logo" data-name="Emploi du temps"></i>
        <i class="fas fa-tasks tasks-logo" data-name="Instructions"></i>
        <i class="fas fa-question-circle help-logo" data-name="Aide"></i>
    </div>
    <section class="content">
    </section>
    <div class="user-profile-right">
        <div class="user-auth">
            <div class="user-logo">
                <?php if($profilePhoto === null || $profilePhoto === ''):?>
                    <i class="fas fa-user-circle user-profile-photo"></i>
                    <i class="fas fa-plus user-profile-photo-edit"></i>
                <?php else:?>
                    <img src='display-profile-photo.php' class="user-profile-photo"></img>
                    <i class="fas fa-plus user-profile-photo-edit"></i>
                <?php endif ?>
            </div>
            <p class="user-pseudo">Pseudo</p>
        </div>
        <div class="date">
            <?= DateHelper::getInstance()->getCurrentDate();?>
        </div>
    </div>
</section>
