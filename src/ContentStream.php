<?php
namespace wapmorgan\FileTypeDetector;

use \Exception;

class ContentStream {
    protected $fp;
    protected $read = array();

    public function __construct($source) {
        if (is_string($source) && file_exists($source)) {
            $this->fp = fopen($source, 'rb');
        } else if (is_resource($source) && get_resource_type($source) == 'stream') {
            $this->fp = $source;
        } else {
            throw new Exception('Unknown source: '.var_export($source, true).' ('.gettype($source).')');
        }
    }

    public function checkBytes($offset, array $bytes) {
        foreach ($bytes as $i => $byte) {
            if (!isset($this->read[$offset+$i])) {
                fseek($this->fp, $offset+$i, SEEK_SET);
                $this->read[$offset+$i] = ord(fgetc($this->fp));
            }
            if ($this->read[$offset+$i] !== $byte)
                return false;
        }
        return true;
    }

    public function __destruct() {
        fclose($this->fp);
    }
}
