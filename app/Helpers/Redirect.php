<?php


namespace App\Helpers;


class Redirect
{
    /**
     * @param string $location
     */
    public static function to(string $location)
    {
       if ($location){
           header("Location:{$location}");
           exit();
       }

    }
}