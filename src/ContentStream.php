<?php declare(strict_types = 1);

namespace wapmorgan\FileTypeDetector;

use Exception;
use function abs;
use function assert;
use function fclose;
use function feof;
use function fgetc;
use function file_exists;
use function fopen;
use function fseek;
use function fstat;
use function get_resource_type;
use function gettype;
use function is_array;
use function is_resource;
use function is_string;
use function ord;
use function stream_get_meta_data;
use function strlen;
use function var_export;
use const SEEK_SET;

class ContentStream
{
    /**
     * @var bool
     */
    protected $openedOutside = false;

    /**
     * @var resource
     */
    protected $filePointer;

    /**
     * @var mixed[]
     */
    protected $read = [];


    /**
     * @param resource|string $source
     *
     * @throws Exception
     */
    public function __construct($source)
    {
        // open regular file
        if (is_string($source) && file_exists($source)) {
            $filePointer = fopen($source, 'rb');
        } else if (is_resource($source) && get_resource_type($source) === 'stream') { // open stream
            $filePointer = $source;
            $this->openedOutside = true;
            // cache all data if stream is not seekable
            $meta = stream_get_meta_data($source);
            if (!$meta['seekable']) {
                while (!feof($source)) {
                    $character = fgetc($source);
                    assert($character !== false);

                    $this->read[] = ord($character);
                }
            }
        } else {
            throw new Exception('Unknown source: ' . var_export($source, true) . ' (' . gettype($source) . ')');
        }

        assert(is_resource($filePointer));
        $this->filePointer = $filePointer;
    }


    /**
     * @param string|int[] $ethalon
     */
    public function checkBytes(int $offset, $ethalon): bool
    {
        if ($offset < 0) {
            $stat = fstat($this->filePointer);
            $offset = $stat['size'] + $offset;
        }
        if (!is_array($ethalon)) {
            $ethalon = $this->convertToBytes($ethalon);
        }
        foreach ($ethalon as $i => $byte) {
            if (!isset($this->read[$offset + $i])) {
                fseek($this->filePointer, $offset + $i, SEEK_SET);
                $character = fgetc($this->filePointer);
                assert($character !== false);
                $this->read[$offset + $i] = ord($character);
            }
            if ($this->read[$offset + $i] !== $byte) {
                return false;
            }
        }

        return true;
    }


    /**
     * @return int[]
     */
    public function convertToBytes(string $string): array
    {
        $bytes = [];
        $l = strlen($string);
        for ($i = 0; $i < $l; $i++) {
            $bytes[$i] = ord($string[$i]);
        }

        return $bytes;
    }


    /**
     * @param mixed[] $bytes
     */
    public function find(int $offset, array $bytes, int $maxDepth = 512, bool $reverse = false): bool
    {
        if ($offset < 0) {
            $stat = fstat($this->filePointer);
            $offset = $stat['size'] + $offset;
        }
        $i = 0;
        while (abs($i) <= $maxDepth) {
            $i = $reverse ? $i - 1 : $i + 1;

            if (!isset($this->read[$offset + $i])) {
                fseek($this->filePointer, $offset + $i, SEEK_SET);
                $character = fgetc($this->filePointer);
                assert($character !== false);
                $this->read[$offset + $i] = ord($character);
            }

            foreach ($bytes as $j => $byte) {
                if (is_string($byte)) {
                    $byte = ord($byte);
                }
                if ($this->read[$offset + $i + $j] !== $byte) {
                    continue 2;
                }
            }

            return true;
        }

        return false;
    }


    public function __destruct()
    {
        if (!$this->openedOutside) {
            fclose($this->filePointer);
        }
    }
}
