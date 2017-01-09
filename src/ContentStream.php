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
        if ($offset < 0) {
            $stat = fstat($this->fp);
            $offset = $stat['size'] + $offset;
        }
        foreach ($bytes as $i => $byte) {
            if (!isset($this->read[$offset+$i])) {
                fseek($this->fp, $offset+$i, SEEK_SET);
                $this->read[$offset+$i] = ord(fgetc($this->fp));
            }
            if (is_string($byte)) $byte = ord($byte);
            if ($this->read[$offset+$i] !== $byte)
                return false;
        }
        return true;
    }

    public function find($offset, array $bytes, $maxDepth = 512, $forward = true) {
        if ($offset < 0) {
            $stat = fstat($this->fp);
            $offset = $stat['size'] + $offset;
        }
        $i = 0;
        while (abs($i) <= $maxDepth) {
            $i = $forward ? $i + 1 : $i - 1;

            if (!isset($this->read[$offset+$i])) {
                fseek($this->fp, $offset+$i, SEEK_SET);
                $this->read[$offset+$i] = ord(fgetc($this->fp));
            }

            foreach ($bytes as $j => $byte) {
                if (is_string($byte)) $byte = ord($byte);
                if ($this->read[$offset+$i+$j] != $byte)
                    continue(2);

            }
            return true;
        }
        return false;
    }

    public function __destruct() {
        fclose($this->fp);
    }
}
