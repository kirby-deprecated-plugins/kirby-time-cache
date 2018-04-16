<?php
class TimeCacheResponse extends Kirby\Component\Response {
    public function make($response) {
        if(is_string($response)) {
            return $this->kirby->render(page($response));
        } else if(is_array($response)) {
            return $this->kirby->render(page($response[0]), $response[1]);
        } else if(is_a($response, 'Page')) {
            $TimeCache = new TimeCache();

            if($this->isBlacklisted($response->format())) {
                return $response;
            }

            $html = parent::make($response);
            $relative_url = str_replace(url::index(), '', url::current());
            $filepath = $TimeCache->filepath($relative_url);

            if(c::get('time.cache.pages.comments', false)) {
                $text = "<!--\n\n";
                $text .= "TIMECACHE ID:\n" . $relative_url . "\n\n";
                $text .= "TIMECACHE FILENAME:\n" . md5($relative_url) . "\n\n";
                $text .= "TIMECACHE TIMESTAMP:\n" . time() . "\n\n";
                $text .= "-->";
            }

            $html = time::cache($relative_url, function() use ($html, $text) {
                return str_replace('</html>', "\n" . $text . "\n</html>", $html);
            }, c::get('time.cache.pages.expires', 86400));
            return $html;
        } else if(is_a($response, 'Response')) {
            return $response;
        } else {
            return null;
        }
    }
    
    private function isBlacklisted($format, $blacklist = ['js', 'css']) {
        return in_array($format, $blacklist);
    }
}

$kirby->set('component', 'response', 'TimeCacheResponse');