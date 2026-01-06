<?php
    declare(strict_types=1);
    function getnavigateur(): string
    {
        $userAgent= $_SERVER["HTTP_USER_AGENT"];
        $browsers = array(
            'Mozilla Firefox'=>'Firefox',
            'Opera'=>'OPR',
            'Microsoft Edge'=>'Edg',
            'Google Chrome'=>'Chrome',
            'Apple Safari'=>'Safari',
            'Internet Explorer'=>'MSIE',
        );
        $browser = "un navigateur inconnu";
        foreach ($browsers as $name=>$value) {
            if (strstr($userAgent,$value)) {
                $browser = $name;
                break;
            }
        }

        return "Vous naviguez sur <strong><em>".$browser."</em></strong>";
    }
?>