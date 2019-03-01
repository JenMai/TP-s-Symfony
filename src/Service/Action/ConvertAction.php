<?php

namespace App\Service\Action;

class ConvertAction{

    public static function convertDirectionToX(string $direction){
        switch ($direction){
            case 'TOP':
                return -1;
            case 'BOTTOM':
                return 1;
            default:
                return 0;
        }
    }

    public static function convertDirectionToY(string $direction){
        switch ($direction){
            case 'LEFT':
                return -1;
            case 'RIGHT':
                return 1;
            default:
                return 0;
        }
    }
}