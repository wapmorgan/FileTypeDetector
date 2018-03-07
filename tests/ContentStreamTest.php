<?php
namespace wapmorgan\test\FileTypeDetector;

use PHPUnit\Framework\TestCase;
use wapmorgan\FileTypeDetector\ContentStream;

class ContentStreamTest extends TestCase {

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage Unknown source: 'invalid_file' (string)
     */
    public function testConstructorShouldReturnExceptionIfFileIsNotExisted() {
        $contentStream = new ContentStream('invalid_file');
    }

    public function testConstructorShouldOpenRegularFile() {
        $contentStream = new ContentStream(__DIR__. '/image.jpeg');

        $this->assertFalse($contentStream->find(0, [128]));
        unset($contentStream);
    }

    public function testFindWithNegativeOffset() {
        $contentStream = new ContentStream(__DIR__. '/image.jpeg');

        $this->assertFalse($contentStream->find(-1, [128]));
        unset($contentStream);
    }

    public function testFindWithReverseIsTrue() {
        $contentStream = new ContentStream(__DIR__. '/image.jpeg');

        $this->assertTrue($contentStream->find(-1, [128], 512, true));
        unset($contentStream);
    }
}