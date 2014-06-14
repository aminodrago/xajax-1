<?php

namespace Xajax;

use Composer\Script\Event;

class Composer {

    public static function postUpdate(Event $event) {
        $io = $event->getIO();
        self::copyJs($io);
    }

    public static function postInstall(Event $event) {
        $io = $event->getIO();
        self::copyJs($io);
    }

    //копирует файлы JS в каталог www/js/xajax/
    public static function copyJs($io) {
        define('DS', DIRECTORY_SEPARATOR);
        $patternFrom = __DIR__ . '/xajax/xajax_js/*.js';
        $pathTo = __DIR__ . DS.'..'.DS.'..'.DS.'..'.DS.'www'.DS.'js'.DS.'xajax';
        //var_dump($pathTo);
        //$io->write($pathTo);
        //return NULL;
        $patternTo = $pathTo . '/*.js';

        if (!is_dir($pathTo)) {
            mkdir($pathTo, NULL, TRUE);
        } else {
            $files = glob($patternTo);
            foreach ($files as $file) {
                unlink($file);
            }
        }
        $files = glob($patternFrom);
        foreach ($files as $file) {
            copy($file, $pathTo . '/' . basename($file));
        }
        $io->write('Copies js files to directory ' . $pathTo);
    }

}
