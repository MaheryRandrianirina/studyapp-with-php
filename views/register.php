<?php

use App\Controllers\FormController;
use App\Controllers\SessionController;

SessionController::setSessionStart();
use src\helpers\views\Form;

$title = "Inscription";
$js = "./assets/register.a4d67f20b4598484764f.js";

?>
<form class="register-form-container" method="POST" action="<?=$router->generate('postRegisterAction')?>">
    <div class="input-container container-one">
        <label for="pseudo">Pseudo</label>
        <input type="text" id="pseudo" autocomplete="off" name="pseudo">
        <?=FormController::showErrors("register_errors", "pseudo", $_SESSION) ?? null?>
        <label for="mail">Adresse mail</label>
        <input type="email" id="mail" autocomplete="off" name="mail">
        <?=FormController::showErrors("register_errors", "mail", $_SESSION) ?? null?>
        <label for="birth">Date de naissance</label>
        <input type="date" id="birth" autocomplete="off" name="birth">
        <?=FormController::showErrors("register_errors", "birth", $_SESSION) ?? null?>
    </div>
    <div class="input-container container-two">
        <label for="pays">Pays</label>
        <select name="pays" id="pays">
        <?php Form::option(["madagascar" => "Madagascar", "france" => "France", "etats-unis" => "Etats-Unis"]);?>
        </select>
        <label for="region">Région</label>
        <select name="regions" id="pregions">
        <?php Form::option(["fianarantsoa" => "Fianarantsoa", "tana" => "Tana", "tamatave" => "Tamataves"]);?>
        </select>
        <label for="sexe">Sexe</label>
        <select name="sexe" id="sexe">
        <?php Form::option(["homme" => "Homme", "femme" => "Femme"]);?>
        </select>
    </div>
    <div class="input-container container-three">
        <?= Form::requirements()?>
        <label for="pwd">Mot de passe</label>
        <input type="password" id="pwd" name="pwd">
        <?=FormController::showErrors("register_errors", "pwd", $_SESSION) ?? null?>
        <label for="pwd-confirm">confirmer votre mot de passe</label>
        <input type="password" id="pwd-confirm" name="pwd-confirm">
        <?=FormController::showErrors("register_errors", "pwd-confirm", $_SESSION) ?? null?>
        <button type="submit" name="submitBtn" disabled class="submitBtn registerBtn">S'inscire</button>
    </div>
    <?php
    unset($_SESSION['register_errors']);
    ?>
</form>