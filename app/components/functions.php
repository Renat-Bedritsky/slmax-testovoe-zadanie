<?php

function printAr($array)
{
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function transformationAge($age)
{
    $language = $_COOKIE['language'];
    
    if ($language == 'ru') return ageRU($age);
    else if ($language == 'en') return ageEN($age);
}

function ageRu($age)
{
    if ($age == 1 || ($age%10 == 1 && $age != 11)) {
        return $age . " год";
    }
    else if (($age >=2 && $age <= 4) || ($age%10 >=2 && $age%10 <= 4 && $age >=22)) {
        return $age . " года";
    }
    else if ($age == 0 || ($age >= 5 && $age <= 20) || $age%10 == 5) {
        return $age . " лет";
    }
}

function ageEn($age)
{
    if ($age == 1) {
        return $age . " year";
    }
    else if ($age == 0 || ($age >=2 && $age <= 4) || ($age%10 >=2 && $age%10 <= 4)) {
        return $age . " years";
    }
}
