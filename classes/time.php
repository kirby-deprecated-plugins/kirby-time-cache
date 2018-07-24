<?php

namespace JensTornell;

class Time {
    static $instance = null;

    private static function instance() {
        if (!static::$instance) {
            static::$instance = new \JensTornell\TimeCache();
        }
        return static::$instance;
    }

    public static function cache($filename, $callback, $expires = null) {
        return static::instance()->get($filename, $callback, $expires);
    }

    public static function flush() {
        static::instance()->flush();
    }
}
