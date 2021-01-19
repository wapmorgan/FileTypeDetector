<?php declare(strict_types = 1);

namespace BrandEmbassy\FileTypeDetector;

use Exception;
use InvalidArgumentException;
use function assert;
use function fopen;
use function fwrite;
use function pathinfo;
use function rewind;
use function strtolower;
use const PATHINFO_EXTENSION;

class Detector
{
    /**
     * @var mixed[]
     */
    private static $signatures = [
        // Images signatures
        Extension::JPEG => [
            [0 => [0xFF, 0xD8, 0xFF, 0xE0]],
            [0 => [0xFF, 0xD8, 0xFF, 0xE1]],
        ],
        Extension::BMP => [[0 => [0x42, 0x4D]]],
        Extension::GIF => [
            [0 => [0x47, 0x49, 0x46, 0x38, 0x37, 0x61]],
            // or
            [0 => [0x47, 0x49, 0x46, 0x38, 0x39, 0x61]],
        ],
        Extension::PNG => [[0 => [0x89, 0x50, 0x4E, 0x47, 0x0D, 0x0A, 0x1A, 0x0A]]],
        Extension::TIFF => [
            [0 => [0x49, 0x20, 0x49]],
            // or
            [0 => [0x49, 0x49, 0x2A, 0x00]],
            // or
            [0 => [0x4D, 0x4D, 0x00, 0x2A]],
            // or
            [0 => [0x4D, 0x4D, 0x00, 0x2B]],
        ],
        Extension::PSD => [[0 => [0x38, 0x42, 0x50, 0x53]]],
        Extension::ICO => [[0 => [0x00, 0x00, 0x01, 0x00]]],

        // Archives signatures
        Extension::ARJ => [[0 => [0x60, 0xEA]]],
        Extension::BZIP2 => [[0 => [0x42, 0x5A, 0x68]]],
        Extension::GZIP => [[0 => [0x1F, 0x8B]]],
        Extension::_7ZIP => [[0 => [0x37, 0x7A, 0xBC, 0xAF, 0x27, 0x1C]]],
        Extension::CAB => [[0 => [0x4D, 0x53, 0x43, 0x46]]],
        Extension::JAR => [
            [0 => [0x50, 0x4B, 0x03, 0x04, 0x14, 0x00, 0x08, 0x00, 0x08, 0x00]],
            // or
            [0 => [0x5F, 0x27, 0xA8, 0x89]],
        ],
        Extension::RAR => [
            [0 => [0x52, 0x61, 0x72, 0x21, 0x1A, 0x07, 0x00]],
            // or
            [0 => [0x52, 0x61, 0x72, 0x21, 0x1A, 0x07, 0x01, 0x00]],
        ],
        Extension::TAR => [
            [0 => [0x75, 0x73, 0x74, 0x61, 0x72, 0x00, 0x30, 0x30]],
            // or
            [0 => [0x75, 0x73, 0x74, 0x61, 0x72, 0x20, 0x20, 0x00]],
        ],
        Extension::ARC => [[0 => [0x41, 0x72, 0x43, 0x01]]],
        Extension::DAR => [[0 => [0x00, 0x00, 0x00, 0x7B]]],

        // Disk images signatures
        Extension::ISO => [[0 => [0x43, 0x44, 0x30, 0x30, 0x31]]],
        Extension::NRG => [
            [-8 => ['N', 'E', 'R', 'O']],
            // or
            [-12 => ['N', 'E', 'R', '5']],
        ],

        // Spreadsheets signatures
        Extension::ACCDB => [
            [
                0 => [
                    0x00,
                    0x01,
                    0x00,
                    0x00,
                    0x53,
                    0x74,
                    0x61,
                    0x6E,
                    0x64,
                    0x61,
                    0x72,
                    0x64,
                    0x20,
                    0x41,
                    0x43,
                    0x45,
                    0x20,
                    0x44,
                    0x42,
                ],
            ],
        ],
        Extension::MDB => [
            [
                0 => [
                    0x00,
                    0x01,
                    0x00,
                    0x00,
                    0x53,
                    0x74,
                    0x61,
                    0x6E,
                    0x64,
                    0x61,
                    0x72,
                    0x64,
                    0x20,
                    0x4A,
                    0x65,
                    0x74,
                    0x20,
                    0x44,
                    0x42,
                ],
            ],
        ],
        Extension::SQLITE => [
            [
                0 => [
                    0x53,
                    0x51,
                    0x4C,
                    0x69,
                    0x74,
                    0x65,
                    0x20,
                    0x66,
                    0x6F,
                    0x72,
                    0x6D,
                    0x61,
                    0x74,
                    0x20,
                    0x33,
                    0x00,
                ],
            ],
        ],

        // Microsoft Office old formats (doc, xls, ppt)
        Extension::DOC => [
            [
                0 => [0xD0, 0xCF, 0x11, 0xE0, 0xA1, 0xB1, 0x1A, 0xE1],
                // and
                512 => [0xEC, 0xA5, 0xC1, 0x00],
            ],
        ],
        Extension::XLS => [
            [
                0 => [0xD0, 0xCF, 0x11, 0xE0, 0xA1, 0xB1, 0x1A, 0xE1],
                // and
                512 => [0x09, 0x08, 0x10, 0x00, 0x00, 0x06, 0x05, 0x00],
            ],
        ],
        Extension::PPT => [
            [
                0 => [0xD0, 0xCF, 0x11, 0xE0, 0xA1, 0xB1, 0x1A, 0xE1],
                // and
                512 => [0xA0, 0x46, 0x1D, 0xF0],
            ],
            // or
            [
                0 => [0xD0, 0xCF, 0x11, 0xE0, 0xA1, 0xB1, 0x1A, 0xE1],
                // and
                512 => [0x00, 0x6E, 0x1E, 0xF0],
            ],
            // or
            [
                0 => [0xD0, 0xCF, 0x11, 0xE0, 0xA1, 0xB1, 0x1A, 0xE1],
                // and
                512 => [0x0F, 0x00, 0xE8, 0x03],
            ],
        ],

        // Microsoft Office new formats (docx, xlsx, pptx)
        Extension::DOCX => [
            [
                0 => [0x50, 0x4B, 0x03, 0x04, 0x14, 0x00, 0x06, 0x00],
                // and
                // search for substring at the end of file
                -22 => [
                    'bytes' => ['w', 'o', 'r', 'd', '/'],
                    'depth' => 512,
                    'reverse' => true,
                ],
            ],
        ],
        Extension::XLSX => [
            [
                0 => [0x50, 0x4B, 0x03, 0x04, 0x14, 0x00, 0x06, 0x00],
                // and
                // search for substring at the end of file
                -22 => [
                    'bytes' => ['x', 'l', '/'],
                    'depth' => 512,
                    'reverse' => true,
                ],
            ],
        ],
        Extension::PPTX => [
            [
                0 => [0x50, 0x4B, 0x03, 0x04, 0x14, 0x00, 0x06, 0x00],
                // and
                // search for substring at the end of file
                -22 => [
                    'bytes' => ['p', 'p', 't', '/'],
                    'depth' => 512,
                    'reverse' => true,
                ],
            ],
        ],

        // Open Alliance formats
        Extension::ODT => [
            [
                0 => [0x50, 0x4B, 0x03, 0x04],
                // and
                30 => [
                    'm',
                    'i',
                    'm',
                    'e',
                    't',
                    'y',
                    'p',
                    'e',
                    'a',
                    'p',
                    'p',
                    'l',
                    'i',
                    'c',
                    'a',
                    't',
                    'i',
                    'o',
                    'n',
                    '/',
                    'v',
                    'n',
                    'd',
                    '.',
                    'o',
                    'a',
                    's',
                    'i',
                    's',
                    '.',
                    'o',
                    'p',
                    'e',
                    'n',
                    'd',
                    'o',
                    'c',
                    'u',
                    'm',
                    'e',
                    'n',
                    't',
                    '.',
                ],
                // and
                73 => ['t', 'e', 'x', 't'],
            ],
        ],
        Extension::ODS => [
            [
                0 => [0x50, 0x4B, 0x03, 0x04],
                // and
                30 => [
                    'm',
                    'i',
                    'm',
                    'e',
                    't',
                    'y',
                    'p',
                    'e',
                    'a',
                    'p',
                    'p',
                    'l',
                    'i',
                    'c',
                    'a',
                    't',
                    'i',
                    'o',
                    'n',
                    '/',
                    'v',
                    'n',
                    'd',
                    '.',
                    'o',
                    'a',
                    's',
                    'i',
                    's',
                    '.',
                    'o',
                    'p',
                    'e',
                    'n',
                    'd',
                    'o',
                    'c',
                    'u',
                    'm',
                    'e',
                    'n',
                    't',
                    '.',
                ],
                // and
                73 => ['s', 'p', 'r', 'e', 'a', 'd', 's', 'h', 'e', 'e', 't'],
            ],
        ],
        Extension::ODP => [
            [
                0 => [0x50, 0x4B, 0x03, 0x04],
                // and
                30 => [
                    'm',
                    'i',
                    'm',
                    'e',
                    't',
                    'y',
                    'p',
                    'e',
                    'a',
                    'p',
                    'p',
                    'l',
                    'i',
                    'c',
                    'a',
                    't',
                    'i',
                    'o',
                    'n',
                    '/',
                    'v',
                    'n',
                    'd',
                    '.',
                    'o',
                    'a',
                    's',
                    'i',
                    's',
                    '.',
                    'o',
                    'p',
                    'e',
                    'n',
                    'd',
                    'o',
                    'c',
                    'u',
                    'm',
                    'e',
                    'n',
                    't',
                    '.',
                ],
                // and
                73 => ['p', 'r', 'e', 's', 'e', 'n', 't', 'a', 't', 'i', 'o', 'n'],
            ],
        ],
        Extension::ODB => [
            [
                0 => [0x50, 0x4B, 0x03, 0x04],
                // and
                30 => [
                    'm',
                    'i',
                    'm',
                    'e',
                    't',
                    'y',
                    'p',
                    'e',
                    'a',
                    'p',
                    'p',
                    'l',
                    'i',
                    'c',
                    'a',
                    't',
                    'i',
                    'o',
                    'n',
                    '/',
                    'v',
                    'n',
                    'd',
                    '.',
                    'o',
                    'a',
                    's',
                    'i',
                    's',
                    '.',
                    'o',
                    'p',
                    'e',
                    'n',
                    'd',
                    'o',
                    'c',
                    'u',
                    'm',
                    'e',
                    'n',
                    't',
                    '.',
                ],
                // and
                73 => ['b', 'a', 's', 'e'],
            ],
        ],

        // Text formats
        Extension::HTML => [[0 => '<html']],
        Extension::PDF => [[0 => [0x25, 0x50, 0x44, 0x46]]],
        Extension::RTF => [[0 => [0x7B, 0x5C, 0x72, 0x74, 0x66, 0x31]]],
        Extension::ATOM => [
            [
                0 => '<?xml',
                // and
                // search for substring "Atom" in the second xml tag
                10 => [
                    'bytes' => ['A', 't', 'o', 'm'],
                    'depth' => 100,
                ],
            ],
        ],
        Extension::RSS => [
            [
                0 => '<?xml',
                // search for substring "<rss" at the start of file
                10 => [
                    'bytes' => ['<', 'r', 's', 's'],
                    'depth' => 100,
                ],
            ],
        ],
        // make sure xml at the end of Text's section
        Extension::XML => [[0 => '<?xml']],

        // Font formats
        Extension::OTF => [[0 => [0x4F, 0x54, 0x54, 0x4F]]],
        Extension::TTF => [[0 => [0x00, 0x01, 0x00, 0x00, 0x00]]],

        // Executables formats
        Extension::APK => [
            [
                0 => [0x50, 0x4B, 0x03, 0x04],
                // and
                30 => ['A', 'n', 'd', 'r', 'o', 'i', 'd', 'M', 'a', 'n', 'i', 'f', 'e', 's', 't', '.', 'x', 'm', 'l'],
            ],
        ],
        Extension::EXE => [[0 => [0x4D, 0x5A]]],

        // Audios formats
        Extension::FLAC => [[0 => [0x66, 0x4C, 0x61, 0x43, 0x00, 0x00, 0x00, 0x22]]],
        Extension::AMR => [[0 => [0x23, 0x21, 0x41, 0x4D, 0x52]]],
        Extension::MP3 => [[0 => [0x49, 0x44, 0x33]]],
        Extension::AAC => [
            [0 => [0xFF, 0xF1]],
            // or
            [0 => [0xFF, 0xF9]],
        ],
        Extension::M3U => [[0 => ['#', 'E', 'X', 'T', 'M', '3', 'U']]],
        Extension::OGG => [
            [0 => ['O', 'g', 'g', 'S']],
            // or
            [0 => [0x4f, 0x67, 0x67, 0x53]],
        ],
        Extension::MIDI => [[0 => [0x4D, 0x54, 0x68, 0x64]]],

        Extension::_3GP => [[0 => [0x00, 0x00, 0x00, 0x14, 0x66, 0x74, 0x79, 0x70, 0x33, 0x67, 0x70]]],
        Extension::AVI => [
            [
                0 => [0x52, 0x49, 0x46, 0x46],
                // and
                8 => [0x41, 0x56, 0x49, 0x20, 0x4C, 0x49, 0x53, 0x54],
            ],
        ],
        Extension::FLV => [[0 => [0x46, 0x4C, 0x56, 0x01]]],
        Extension::M4V => [[0 => [0x00, 0x00, 0x00, 0x18, 0x66, 0x74, 0x79, 0x70, 0x6D, 0x70, 0x34, 0x32]]],
        Extension::MKV => [
            [
                0 => [
                    0x1A,
                    0x45,
                    0xDF,
                    0xA3,
                    0x93,
                    0x42,
                    0x82,
                    0x88,
                    0x6D,
                    0x61,
                    0x74,
                    0x72,
                    0x6F,
                    0x73,
                    0x6B,
                    0x61,
                ],
            ],
        ],
        Extension::MOV => [
            [4 => [0x66, 0x74, 0x79, 0x70, 0x71, 0x74, 0x20, 0x20]],
            // or
            [4 => [0x6D, 0x6F, 0x6F, 0x76]],
        ],
        Extension::MP4 => [
            [4 => [0x66, 0x74, 0x79, 0x70, 0x69, 0x73, 0x6F, 0x6D]],
            // or
            [4 => [0x66, 0x74, 0x79, 0x70, 0x33, 0x67, 0x70, 0x35]],
            // or
            [4 => [0x66, 0x74, 0x79, 0x70, 0x4D, 0x53, 0x4E, 0x56]],
            // or
            [4 => [0x66, 0x74, 0x79, 0x70, 0x4D, 0x34, 0x41, 0x20]],
        ],
        Extension::MPEG => [
            [
                0 => [0x00, 0x00, 0x01],
                // and
                -4 => [0x00, 0x00, 0x01, 0xB7],
            ],
        ],
        Extension::SWF => [[0 => [0x5A, 0x57, 0x53]]],
        Extension::VOB => [
            [
                0 => [0x00, 0x00, 0x01, 0xBA],
                // and
                -4 => [0x00, 0x00, 0x01, 0xB9],
            ],
        ],
        Extension::WEBM => [[0 => [0x1A, 0x45, 0xDF, 0xA3]]],

        // zip is a container for a lot of formats
        Extension::ZIP => [
            [0 => [0x50, 0x4B, 0x03, 0x04]],
            // or
            [0 => [0x50, 0x4B, 0x05, 0x06]],
            // or
            [0 => [0x50, 0x4B, 0x07, 0x08]],
        ],

        // Scneraios formats
        Extension::REG => [
            [0 => [0xFF, 0xFE]],
            // or
            [0 => [0x52, 0x45, 0x47, 0x45, 0x44, 0x49, 0x54]],
        ],
    ];


    public static function getMimeType(string $file): ?string
    {
        $fileInfo = self::detectFromFilePath($file);

        if ($fileInfo === null) {
            return null;
        }

        return $fileInfo->getMimeType();
    }


    public static function detectFromFilePath(string $filePath): ?FileInfo
    {
        return self::detectByFileName($filePath) ?? self::detectByContent($filePath);
    }


    public static function detectFromContent(string $content): ?FileInfo
    {
        $source = fopen('php://memory', 'rb+');
        assert($source !== false);

        fwrite($source, $content);
        rewind($source);

        return self::detectByContent($source);
    }


    public static function detectByFileName(string $filename): ?FileInfo
    {
        $extension = self::resolveExtensionFromFileName($filename);

        if ($extension === null) {
            return null;
        }

        return new FileInfo($extension, true);
    }


    private static function resolveExtensionFromFileName(string $fileName): ?Extension
    {
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        try {
            return Extension::getIncludingAliases($extension);
        } catch (InvalidArgumentException $exception) {
            return null;
        }
    }


    /**
     * @param resource|string $source
     *
     * @throws Exception
     */
    public static function detectByContent($source): ?FileInfo
    {
        $stream = new ContentStream($source);
        foreach (self::$signatures as $format => $signatures) {
            foreach ($signatures as $orSignature) {
                $passed = true;
                foreach ($orSignature as $offset => $andSignature) {
                    // search for substring in range
                    if (isset($andSignature['bytes'])) {
                        if ($stream->find(
                            $offset,
                            $andSignature['bytes'],
                            $andSignature['depth'] ?? 512,
                            $andSignature['reverse'] ?? false
                        ) === false) {
                            $passed = false;
                            break;
                        }
                    } else {
                        if ($stream->checkBytes($offset, $andSignature) === false) { // exact match
                            $passed = false;
                            break;
                        }
                    }
                }
                // if earlier we did not break inner loop, then all signatures matched
                if ($passed) {
                    $extension = Extension::get($format);

                    return new FileInfo($extension, false);
                }
            }
        }

        return null;
    }
}
