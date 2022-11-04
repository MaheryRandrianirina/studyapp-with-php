<?php
namespace src\helpers\views;

class Subject {
    public static function getView(string $principal_class, string $specific_class, $subjectInfos = []): string
    {
        return '
<div class="'.$principal_class.' '. $specific_class.'">
    <p class=subject-name>NOM DE MATIERE</p>
    <i class="fas fa-play revision-play"></i>
    <p class="heure-revision">HEURE</p>
</div>';
    }
}