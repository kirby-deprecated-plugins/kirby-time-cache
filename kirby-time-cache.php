<?php
if(c::get('time.cache.pages', false)) {
    include __DIR__ . '/components/response.php';
}

class TimeCache {
    public function get($filename, $callback, $expires) {
        $this->filename = $filename;
        $this->callback = $callback;
        $this->timeout = ($expires) ? $expires : c::get('time.cache.expires', 84400);
        $this->filepath = $this->filepath($filename);

        if($this->expired()) {
            return $this->write();
        } else {
            return $this->read();
        }
    }

    private function data() {
        if(is_callable($this->callback)) {
            return call($this->callback);
        }
    }

    private function hash() {
        return c::get('time.cache.filename.hash', true);
    }

    private function dirpath() {
        return c::get('time.cache.path', kirby()->roots()->site() . '/cache-time');
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
        return $this->dirpath() . DS.  $filename;
    }

    private function expired() {
        $diff = time() - f::modified($this->filepath);
        if($diff > $this->timeout) return true;
    }

    private function read() {
        return f::read($this->filepath);
    }

    private function write() {
        f::write($this->filepath, $this->data());
        return $this->read();
    }
}

class time {
    public static function cache($filename, $callback, $expires = null) {
        $TimeCache = new TimeCache();
        return $TimeCache->get($filename, $callback, $expires);
    }
}