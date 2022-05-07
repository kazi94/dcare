<?php

namespace App\Traits;

trait TeethTrait
{
    /**
     * Check if is full mouth
     *
     * @param [type] $tooth
     * @return boolean
     */
    public function isMouth($tooth)
    {
        return $tooth == "11,12,13,14,15,16,17,18,21,22,23,24,25,26,27,28,41,42,43,44,45,46,47,48,31,32,33,34,35,36,37,38";
    }
    /**
     * Return tooth number from defined sector
     *
     * @param [String] $sector
     * @return String
     */
    public function getToothFrom($sector)
    {
        $tooth = [];
        switch ($sector) {
            case "s1":
                $tooth = "11, 12, 13, 14, 15, 16, 17, 18";
                break;
            case "s2":
                $tooth = "21, 22, 23, 24, 25, 26, 27, 28";
                break;
            case "s3":
                $tooth = "41, 42, 43, 44, 45, 46, 47, 48";
                break;
            case "s4":
                $tooth = "31, 32, 33, 34, 35, 36, 37, 38";
                break;
            case "Bouche":
                $tooth = "11,12,13,14,15,16,17,18,21,22,23,24,25,26,27,28,41,42,43,44,45,46,47,48,31,32,33,34,35,36,37,38";
                break;
            default:
                $tooth = $sector;
                break;
        }
        return $tooth;
    }
}
