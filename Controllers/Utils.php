<?php

class Utils
{

    public static function capitalizeFirstLetter($string)
    {
        return ucfirst(strtolower($string));
    }

    public static function capitalizeEachWord($string)
    {
        return ucwords(strtolower($string));
    }

}

?>