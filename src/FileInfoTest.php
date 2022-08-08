<?php declare(strict_types = 1);

namespace BrandEmbassy\FileTypeDetector;

use PHPUnit\Framework\TestCase;

class FileInfoTest extends TestCase
{
    /**
     * @dataProvider extensionDataProvider()
     */
    public function testFileInfoAlwaysHasAllAttributes(Extension $extension, bool $isCreatedFromFileName): void
    {
        $fileInfo = new FileInfo($extension, $isCreatedFromFileName);

        $fileInfo->getExtension();
        $fileInfo->getFileType();
        $fileInfo->getMimeType();
        $fileInfo->isCreatedFromFileName();

        $this->expectNotToPerformAssertions();
    }


    /**
     * @return iterable<array<Extension|bool>>
     */
    public function extensionDataProvider(): iterable
    {
        foreach (Extension::getValues() as $value) {
            yield [Extension::get($value), true];
            yield [Extension::get($value), false];
        }
    }
}
