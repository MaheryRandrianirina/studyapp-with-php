<?php
namespace src\helpers\views;
/**
 * MBOLA HATAO GENERATION AUTO
 */
class Form {
    public static function label()
    {
        
    }
    public static function input()
    {

    }
    public static function register(): string
    {
        return <<<HTML
        <div class="input-container container-one">
            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo">
            <label for="mail">Email</label>
            <input type="email" id="mail">
            <label for="age">Age</label>
            <input type="number" id="age">
        </div>
HTML;
    }

    public static function count($values = []): int
    {
        $i = 0;
        foreach($values as $value){
            $i = $i + 1;
        }

        return $i;
    }

    public static function option($optionVar = [])
    {
        foreach($optionVar as $value => $content){
            echo <<<HTML
            <option value="{$value}">{$content}</option>
HTML;
        }
    }

    public static function requirements(): string
    {
        return <<<HTML
        <div class="indications">
            <i class="fas fa-check condition-check"></i><span class="letters_number_condition">contient au moins 8 lettres</span><br>
            <i class="fas fa-check condition-check"></i><span class="one_number_condition">contient au moins un nombre</span>
        </div>
HTML;
    }
}