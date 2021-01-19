<?php declare(strict_types = 1);

namespace BrandEmbassy\FileTypeDetector;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use function array_map;
use function assert;
use function fclose;
use function file_get_contents;
use function fopen;
use function fwrite;
use function implode;
use function is_resource;
use function rewind;

class DetectorTest extends TestCase
{
    /**
     * @dataProvider fileNameDataProvider()
     */
    public function testDetectionByFileName(
        string $fileName,
        string $expectedFileType,
        string $expectedExtension,
        string $expectedMimeType
    ): void {
        $fileInfo = Detector::detectByFileName($fileName);
        assert($fileInfo !== null);

        $this->assertFileInfo($fileInfo, $expectedFileType, $expectedExtension, $expectedMimeType);
    }


    /**
     * @return mixed[][]
     */
    public function fileNameDataProvider(): array
    {
        return [
            'jpg' => [
                'fileName' => 'image.jpg',
                'expectedFileType' => FileType::IMAGE,
                'expectedExtension' => Extension::JPEG,
                'expectedMimeType' => 'image/jpeg',
            ],
            'JPG' => [
                'fileName' => 'image.JPG',
                'expectedFileType' => FileType::IMAGE,
                'expectedExtension' => Extension::JPEG,
                'expectedMimeType' => 'image/jpeg',
            ],
            'jpeg' => [
                'fileName' => 'image.jpeg',
                'expectedFileType' => FileType::IMAGE,
                'expectedExtension' => Extension::JPEG,
                'expectedMimeType' => 'image/jpeg',
            ],
            'mp3' => [
                'fileName' => 'sample.mp3',
                'expectedFileType' => FileType::AUDIO,
                'expectedExtension' => Extension::MP3,
                'expectedMimeType' => 'audio/mpeg',
            ],
        ];
    }


    /**
     * @dataProvider binaryStreamDataProvider()
     *
     * @param mixed[] $binary
     */
    public function testDetectionByContent(
        array $binary,
        string $expectedFileType,
        string $expectedExtension,
        string $expectedMimeType
    ): void {
        $filePointer = fopen('php://temp', 'rb+');
        assert(is_resource($filePointer));

        $binary = implode('', array_map('chr', $binary));

        fwrite($filePointer, $binary);
        rewind($filePointer);

        $fileInfo = Detector::detectByContent($filePointer);
        assert($fileInfo !== null);

        $this->assertFileInfo($fileInfo, $expectedFileType, $expectedExtension, $expectedMimeType);

        fclose($filePointer);
    }


    /**
     * @return mixed[][]
     */
    public function binaryStreamDataProvider(): array
    {
        return [
            'png' => [
                'binary' => [0x89, 0x50, 0x4E, 0x47, 0x0D, 0x0A, 0x1A, 0x0A],
                'expectedFileType' => FileType::IMAGE,
                'expectedExtension' => Extension::PNG,
                'expectedMimeType' => 'image/png',
            ],
            'jpeg' => [
                'binary' => [0xFF, 0xD8, 0xFF, 0xE1],
                'expectedFileType' => FileType::IMAGE,
                'expectedExtension' => Extension::JPEG,
                'expectedMimeType' => 'image/jpeg',
            ],
            'jpeg2' => [
                'binary' => [0xFF, 0xD8, 0xFF, 0xE0, 0x00, 0x10, 0x4A, 0x46, 0x49, 0x46, 0x00, 0x01],
                'expectedFileType' => FileType::IMAGE,
                'expectedExtension' => Extension::JPEG,
                'expectedMimeType' => 'image/jpeg',
            ],
            'gzip' => [
                'binary' => [0x1F, 0x8B],
                'expectedFileType' => FileType::ARCHIVE,
                'expectedExtension' => Extension::GZIP,
                'expectedMimeType' => 'application/gzip',
            ],
        ];
    }


    /**
     * @dataProvider filePathDataProvider()
     */
    public function testDetectionFromFilePath(
        string $filePath,
        string $expectedFileType,
        string $expectedExtension,
        string $expectedMimeType
    ): void {
        $fileInfo = Detector::detectFromFilePath($filePath);
        assert($fileInfo !== null);

        $this->assertFileInfo($fileInfo, $expectedFileType, $expectedExtension, $expectedMimeType);
    }


    /**
     * @dataProvider filePathDataProvider()
     */
    public function testDetectionFromContent(
        string $filePath,
        string $expectedFileType,
        string $expectedExtension,
        string $expectedMimeType
    ): void {
        $fileContent = file_get_contents($filePath);
        assert($fileContent !== false);

        $fileInfo = Detector::detectFromContent($fileContent);
        assert($fileInfo !== null);

        $this->assertFileInfo($fileInfo, $expectedFileType, $expectedExtension, $expectedMimeType);
    }


    /**
     * @return string[][]
     */
    public function filePathDataProvider(): array
    {
        return [
            [
                'filePath' => __DIR__ . '/__fixtures__/image.png',
                'expectedFileType' => 'image',
                'expectedExtension' => 'png',
                'expectedMimeType' => 'image/png',
            ],
            [
                'filePath' => __DIR__ . '/__fixtures__/image-without-extension',
                'expectedFileType' => 'image',
                'expectedExtension' => 'png',
                'expectedMimeType' => 'image/png',
            ],
        ];
    }


    private function assertFileInfo(
        FileInfo $fileInfo,
        string $expectedFileType,
        string $expectedExtension,
        string $expectedMimeType
    ): void {
        $fileType = $fileInfo->getFileType();
        assert($fileType !== null);

        $extension = $fileInfo->getExtension();
        assert($extension !== null);

        Assert::assertSame($expectedFileType, $fileType->getValue());
        Assert::assertSame($expectedExtension, $extension->getValue());
        Assert::assertSame($expectedMimeType, $fileInfo->getMimeType());
    }
}
