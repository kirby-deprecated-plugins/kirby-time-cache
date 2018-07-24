<?php

namespace JensTornell;

/* TODO: rewrite as kirby 3 component and setup load via plugin config.php
if (option('jenstornell.time-cache.pages')) {
    include __DIR__ . '/components/response.php';
}
*/

class TimeCache {
    public function get($filename, $callback, $expires) {
        $cache = kirby()->cache('jenstornell.time-cache');
        $timeout = ($expires) ? $expires : option('jenstornell.time-cache.expires');

        $response = $cache->get($filename);
        if(!$response) {
            $response = self::data($callback);
            $cache->set(
                $filename,
                $response,
                intval(ceil(floatval($timeout) / 60.0)) // minutes
            );
        }
        return $response;
    }

    public function flush() {
        kirby()->cache('jenstornell.time-cache')->flush();
    }

    private function data($callback) {
        if(is_callable($callback)) {
            return call_user_func_array($callback, []);
        }
    }
    
}
