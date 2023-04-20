<?php declare(strict_types = 1);

namespace BrandEmbassy\FileTypeDetector;

use LogicException;
use MabeEnum\Enum;
use function in_array;
use function sprintf;
use function trigger_error;
use const E_USER_DEPRECATED;

/**
 * @method string getValue()
 *
 * @final
 */
class FileType extends Enum
{
    public const AUDIO = 'audio';
    public const VIDEO = 'video';
    public const IMAGE = 'image';
    public const ARCHIVE = 'archive';
    public const DISK_IMAGE = 'disk_image';
    public const DATABASE = 'database';
    public const DOCUMENT = 'document';
    public const FONT = 'font';
    public const APPLICATION = 'application';
    public const PRESENTATION = 'presentation';
    public const SPREADSHEET = 'spreadsheet';
    public const FEED = 'feed';
    public const SCENARIO = 'scenario';
    public const CERTIFICATE = 'certificate';

    /**
     * @var string[][]
     */
    private static $extensionsMap = [
        self::IMAGE => [
            Extension::JPEG,
            Extension::BMP,
            Extension::GIF,
            Extension::PNG,
            Extension::TIFF,
            Extension::PSD,
            Extension::ICO,
            Extension::SVG,
            Extension::WEBP,
        ],

        self::ARCHIVE => [
            Extension::ARJ,
            Extension::BZIP2,
            Extension::GZIP,
            Extension::LZMA2,
            Extension::_7ZIP,
            Extension::CAB,
            Extension::JAR,
            Extension::RAR,
            Extension::TAR,
            Extension::ZIP,
            Extension::ARC,
            Extension::DAR,
        ],

        self::DISK_IMAGE => [
            Extension::ISO,
            Extension::NRG,
            Extension::VHD,
        ],

        self::DATABASE => [
            Extension::ACCDB,
            Extension::MDB,
            Extension::ODB,
            Extension::SQLITE,
        ],

        self::DOCUMENT => [
            Extension::DOC,
            Extension::DOCX,
            Extension::HTML,
            Extension::ODT,
            Extension::PDF,
            Extension::RTF,
            Extension::TXT,
            Extension::MARKDOWN,
            Extension::JSON,
            Extension::YAML,
            Extension::XML,
        ],

        self::FEED => [
            Extension::ATOM,
            Extension::RSS,
        ],

        self::FONT => [
            Extension::OTF,
            Extension::TTF,
        ],

        self::APPLICATION => [
            Extension::APK,
            Extension::COM,
            Extension::EXE,
            Extension::XAP,
        ],

        self::PRESENTATION => [
            Extension::PPT,
            Extension::PPTX,
            Extension::ODP,
        ],

        self::AUDIO => [
            Extension::FLAC,
            Extension::WMA,
            Extension::AMR,
            Extension::MP3,
            Extension::AAC,
            Extension::M3U,
            Extension::OGG,
            Extension::WAV,
            Extension::MIDI,
            Extension::M4A,
        ],

        self::SPREADSHEET => [
            Extension::ODS,
            Extension::XLS,
            Extension::XLSX,
            Extension::CSV,
            Extension::TSV,
        ],

        self::VIDEO => [
            Extension::_3GP,
            Extension::ASF,
            Extension::AVI,
            Extension::FLV,
            Extension::M4V,
            Extension::MKV,
            Extension::MOV,
            Extension::MPEG,
            Extension::MP4,
            Extension::SWF,
            Extension::VOB,
            Extension::WMV,
            Extension::WEBM,
        ],

        self::SCENARIO => [
            Extension::REG,
        ],

        self::CERTIFICATE => [
            Extension::PEM,
        ],
    ];


    public static function getByExtension(Extension $extension): self
    {
        foreach (self::$extensionsMap as $fileType => $extensions) {
            if (in_array($extension->getValue(), $extensions, true)) {
                return self::get($fileType);
            }
        }

        throw new LogicException(sprintf('File type for extension "%s" does not exist.', $extension->getValue()));
    }


    /**
     * @deprecated use getByExtension instead
     *
     * @see self::getByExtension()
     */
    public function findByExtension(Extension $extension): ?self
    {
        @trigger_error(sprintf('Method %s is deprecated.', __METHOD__), E_USER_DEPRECATED);

        return self::getByExtension($extension);
    }
}
