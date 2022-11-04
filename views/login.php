<?php

use App\Controllers\FormController;
use src\helpers\views\Form;
use App\Controllers\SessionController;

SessionController::setSessionStart();

$title = "login";
$js = "./assets/login.79658a2b216bccb2e154.js";
$navClass = "nav-login"
?>
<section id="login-main">
        <div class="presentation_left">
            <div class="presentation-container">
                <h1 class="presentation-title">APP DE REVISION</h1>
                <p class="presentation-paragraphe">Lorem ipsum dolor sit amet consectetur adipisicing elit. <br> Porro perferendis quis, accusantium provident <br>nostrum perspiciatis. Perspiciatis similique <br>accusamus, autem fugiat rerum maiores sed vel <br>praesentium odio sequi consequatur architecto quo.</p>
            </div>
        </div>
        <div class="login_container_right">
            <?= isset($_SESSION['loginUserNotFound']) ? FormController::showErrors("userNotFound", $_SESSION['loginUserNotFound']) : null?>
            <form action="<?=$router->generate('postLoginAction')?>" method="post" class="login_form">
                <?= Form::requirements()?>
                <label for="pseudo">Entrez votre pseudo</label>
                <div class="pseudo-container">
                    <input type="text" placeholder="pseudo" name="pseudo" id="pseudo" autocomplete="off"><i class="fas fa-user pseudo-logo"></i>
                </div>
                <?= isset($_SESSION['login_errors']) ? FormController::showErrors("login_errors", "pseudo", $_SESSION)['login_errors'] : null?><br>
                <label for="pwd">Entrez votre mot de passe</label>
                <div class="pwd-container">
                    <input type="password" placeholder="mot de passe" id="pwd" name="pwd"><i class="fas fa-lock lock"></i>
                </div>
                <?= isset($_SESSION['uncorrect-password']) ? FormController::showErrors("pwd", $_SESSION["uncorrect-password"]) : null?><br>
                <input type="checkbox" class="remember-me" name="remember-me"><span class="remember-span">Se souvenir de moi</span><br>
                <button type="submit" class="submitBtn" disabled>Se connecter</button>
            </form>
            <div class="have-no-account">Pas de compte ? <a href="<?= $router->generate('registerpage')?>">S'inscrire</a></div>
        </div>
        <?php
        unset($_SESSION['loginUserNotFound']);
        unset($_SESSION['uncorrect-password']);
        ?>
</section>