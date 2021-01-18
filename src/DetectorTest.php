<?php declare(strict_types = 1);

namespace wapmorgan\FileTypeDetector;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use function array_map;
use function assert;
use function fclose;
use function fopen;
use function fwrite;
use function implode;
use function is_resource;
use function rewind;

class DetectorTest extends TestCase
{
    /**
     * @dataProvider filenamesWithTypes()
     *
     * @param mixed[] $expectedType
     */
    public function testDetectionByFilename(string $filename, array $expectedType): void
    {
        Assert::assertSame($expectedType, Detector::detectByFilename($filename));
    }


    /**
     * @return mixed[][]
     */
    public function filenamesWithTypes(): array
    {
        return [
            ['image.jpg', [Detector::IMAGE, Detector::JPEG, 'image/jpeg']],
            ['music.mp3', [Detector::AUDIO, Detector::MP3, 'audio/mpeg']],
        ];
    }


    /**
     * @dataProvider streamsWithTypes()
     *
     * @param mixed[] $binary
     * @param mixed[] $expectedType
     */
    public function testDetectionByContent(array $binary, array $expectedType): void
    {
        $filePointer = fopen('php://temp', 'r+');
        assert(is_resource($filePointer));

        $binary = implode('', array_map('chr', $binary));

        fwrite($filePointer, $binary);
        rewind($filePointer);
        Assert::assertSame($expectedType, Detector::detectByContent($filePointer));
        fclose($filePointer);
    }


    /**
     * @return mixed[][]
     */
    public function streamsWithTypes(): array
    {
        return [
            [[0x89, 0x50, 0x4E, 0x47, 0x0D, 0x0A, 0x1A, 0x0A], [Detector::IMAGE, Detector::PNG, 'image/png']],
            [[0xFF, 0xD8, 0xFF, 0xE1], [Detector::IMAGE, Detector::JPEG, 'image/jpeg']],
            [
                [0xFF, 0xD8, 0xFF, 0xE0, 0x00, 0x10, 0x4A, 0x46, 0x49, 0x46, 0x00, 0x01],
                [Detector::IMAGE, Detector::JPEG, 'image/jpeg'],
            ],
            [[0x1F, 0x8B], [Detector::ARCHIVE, Detector::GZIP, 'application/gzip']],
        ];
    }


    /**
     * @dataProvider filenamesWithTypes()
     *
     * @param mixed[] $expectedType
     */
    public function testMimetypeGeneration(string $filename, array $expectedType): void
    {
        Assert::assertSame($expectedType[2], Detector::getMimeType($filename));
    }
}
