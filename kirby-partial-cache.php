<?php
class PartialCache {
    public function get($filename, $callback, $expires) {
        $this->filename = $filename;
        $this->callback = $callback;
        $this->timeout = ($expires) ? $expires : c::get('partial.cache.expires', 84400);
        $this->comments = c::get('partial.cache.comments', false);
        $this->hash = c::get('partial.cache.filename.hash', true);
        $this->filepath = $this->filepath();

        echo $this->timeout;

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

    private function filepath() {
        $root = (kirby()->roots()->partial()) ? kirby()->roots()->partial() : kirby()->roots()->site() . DS . 'cache-partial';
        $filename = $this->filename;

        if($this->hash) {
            $filename = md5(pathinfo($this->filename, PATHINFO_FILENAME)) . '.' . pathinfo($this->filename, PATHINFO_EXTENSION);
        }
        return $root . DS.  $filename;
    }

    private function expired() {
        $diff = time() - f::modified($this->filepath);
        if($diff > $this->timeout) return true;
    }

    private function read() {
        $data = f::read($this->filepath);
        return ($this->comments) ? $this->before() . $data . $this->after() : $data;
    }

    private function write() {
        f::write($this->filepath, $this->data());
        return $this->read();
    }

    private function before() {
        $text = '';
        $text .= "<!-- Partial Cache -->\n";
        $text .= "<!-- Filename: " . $this->filename . "-->\n";
        $text .= "<!-- Timestamp: " . f::modified($this->filepath) . "-->\n";
        return c::get('partial.cache.before', $text);
    }

    private function after() {
        $text = "\n<!-- Partial Cache ends -->\n\n";
        return c::get('partial.cache.after', $text);
    }
}

class partial {
    public static function cache($filename, $callback, $expires = null) {
        $cache = new PartialCache();
        return $cache->get($filename, $callback, $expires);
    }
}