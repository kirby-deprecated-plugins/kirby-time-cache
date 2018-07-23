<?php

namespace JensTornell;

/* TODO: rewrite as kirby 3 component and setup load via plugin config.php
if (option('jenstornell.time-cache.pages')) {
    include __DIR__ . '/components/response.php';
}
*/

class TimeCache {
    public function get($filename, $callback, $expires) {
        $this->filename = $filename;
        $this->callback = $callback;
        $this->timeout = ($expires) ? $expires : option('jenstornell.time-cache.expires');
        $this->filepath = $this->filepath($filename);

        if($this->expired()) {
            return $this->write();
        } else {
            return $this->read();
        }
    }

    private function call($function, $arguments = array()) {
        if(!is_callable($function)) return false;
        if(!is_array($arguments)) $arguments = array($arguments);
        return call_user_func_array($function, $arguments);
      }

    private function data() {
        if(is_callable($this->callback)) {
            /* NOTE: kirby call() helper does not exist in v3 anymore
                https://github.com/k-next/kirby/blob/d6faf8edf1f21dc841ec57ce998bfdfd21178feb/config/helpers.php
                https://github.com/getkirby/toolkit/blob/master/helpers.php#L279
            */
            return self::call($this->callback);
        }
    }

    private function hash() {
        return option('jenstornell.time-cache.filename.hash');
    }

    private function dirpath() {
        // NOTE: since this option is s closure, call the function now
        return option('jenstornell.time-cache.path')();
    }

    public function filepath($filename) {
        if($this->hash()) {
            $path_parts = pathinfo($filename);
            $part_filename = $path_parts['dirname'] . '/' . $path_parts['filename'];

            $filename = md5($part_filename);
            
            if(!empty($path_parts['extension'])) {
                $filename .= '.' . $path_parts['extension'];
            }
        }
        return $this->dirpath() . DIRECTORY_SEPARATOR .  $filename;
    }

    private function expired() {
        $diff = time() - \F::modified($this->filepath);
        if($diff > $this->timeout) return true;
    }

    private function read() {
        return \F::read($this->filepath);
    }

    private function write() {
        \F::write($this->filepath, $this->data());
        return $this->read();
    }
}
