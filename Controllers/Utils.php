<?php 

class Utils{

    // Capitalize first letter of a string
    public static function capitalizeFirstLetter($string) {
        return ucfirst(strtolower($string));
    }

    // Capitalize first letter of each word
    public static function capitalizeEachWord($string) {
        return ucwords(strtolower($string));
    }

}

?>