<?php

namespace App;

class Helper
{
    public static function ageCalculator($dob)
    {
        if (!empty($dob)) {
            $birthdate = new \DateTime($dob);
            $today = new \DateTime('today');
            $age = $birthdate->diff($today)->y;
            return $age;
        } else {
            return 0;
        }
    }
}
