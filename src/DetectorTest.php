<?php declare(strict_types = 1);

namespace BrandEmbassy\FileTypeDetector;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use ZipArchive;
use function array_map;
use function assert;
use function fclose;
use function file_get_contents;
use function fopen;
use function fwrite;
use function implode;
use function is_resource;
use function rewind;
use function stream_get_meta_data;
use function sys_get_temp_dir;
use function tempnam;

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
     * This tests behavior of Detector on non-seekable streams (eg. HTTP), ZipArchive was used to simulate it locally
     * Saves the files to a temporary ZIP archive, and reads it again to access the contents
     *
     * @dataProvider filePathDataProvider()
     */
    public function testDetectionByContentInZipArchive(
        string $filePath,
        string $expectedFileType,
        string $expectedExtension,
        string $expectedMimeType
    ): void {
        $zipArchiveName = tempnam(sys_get_temp_dir(), 'zip');
        assert($zipArchiveName !== false);

        $zipArchive = new ZipArchive();
        $zipArchive->open($zipArchiveName, ZipArchive::CREATE);
        $zipArchive->addFile($filePath, 'file');
        $zipArchive->close();
        $zipArchive->open($zipArchiveName);

        $stream = $zipArchive->getStream('file');
        assert($stream !== false);

        $streamMetaData = stream_get_meta_data($stream);
        Assert::assertFalse($streamMetaData['seekable']);

        $fileInfo = Detector::detectByContent($stream);
        Assert::assertNotNull($fileInfo);

        $this->assertFileInfo($fileInfo, $expectedFileType, $expectedExtension, $expectedMimeType);
    }


    /**
     * @dataProvider mimeTypeDataProvider()
     */
    public function testResolveExtensionFromMimeType(string $mimeType, Extension $expectedExtension): void
    {
        $extension = Detector::resolveExtensionFromMimeType($mimeType);
        Assert::assertNotNull($extension);

        Assert::assertTrue($extension->is($expectedExtension));
    }


    public function testResolveExtensionFromUnknownMimeType(): void
    {
        Assert::assertNull(Detector::resolveExtensionFromMimeType('unknown/mime-type'));
    }


    /**
     * @return array<array{mimeType: string, expectedExtension: Extension}>
     */
    public function mimeTypeDataProvider(): array
    {
        return [
            [
                'mimeType' => 'image/png',
                'expectedExtension' => Extension::get(Extension::PNG),
            ],
            [
                'mimeType' => 'image/webp',
                'expectedExtension' => Extension::get(Extension::WEBP),
            ],
            [
                'mimeType' => 'application/pdf',
                'expectedExtension' => Extension::get(Extension::PDF),
            ],
            [
                'mimeType' => 'image/jpeg; charset=binary',
                'expectedExtension' => Extension::get(Extension::JPEG),
            ],
            [
                'mimeType' => 'audio/x-m4a; charset=binary',
                'expectedExtension' => Extension::get(Extension::M4A),
            ],
        ];
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
            [
                'filePath' => __DIR__ . '/__fixtures__/empty.pdf',
                'expectedFileType' => 'document',
                'expectedExtension' => 'pdf',
                'expectedMimeType' => 'application/pdf',
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

        Assert::assertSame($expectedFileType, $fileType->getValue());
        Assert::assertSame($expectedExtension, $fileInfo->getExtension()->getValue());
        Assert::assertSame($expectedMimeType, $fileInfo->getMimeType());
    }
}
