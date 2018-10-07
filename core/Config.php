<?php


class Config
{
    public static function getConfig($config){
        $conf=R::getRow( 'SELECT * FROM config WHERE title LIKE ? LIMIT 1',
            [ "%$config%" ]
        );

        return $conf["setting"];
    }

}