<?php

class Config
{
    private static $config = null;

    public static function init($file)
    {
        if (!is_readable($file)) {
            throw new Exception('File ' . $file . ' does not exist');
        }

        $content = file_get_contents($file);

        self::$config = json_decode($content, true);
        if (!$content || json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Config file ' . $file . ' is not valid json file!');
        }
    }

    public static function get($key, $graceful = false)
    {
        if (!self::$config) {
            // TODO better pattern
            throw new Exception('Config init has to be executed first');
        }
        if ($key == 'cdn_static' && defined('__REV_ID')) {
            return sprintf(self::$config[$key], __REV_ID);
        }
        if (isset(self::$config[$key])) {
            return self::$config[$key];
        }
        if(!$graceful) {
            trigger_error('Config: field ' . $key . ' is missing', E_USER_WARNING);
        }
        return null;
    }

}
