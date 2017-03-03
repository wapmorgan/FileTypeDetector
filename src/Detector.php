<?php
namespace wapmorgan\FileTypeDetector;

class Detector {
    const AUDIO = 'audio';
    const VIDEO = 'video';
    const IMAGE = 'image';
    const ARCHIVE = 'archive';
    const DATABASE = 'database';
    const DOCUMENT = 'document';
    const FONT = 'font';
    const APPLICATION = 'application';
    const PRESENTATION = 'presentation';
    const SPREADSHEET = 'spreadsheet';

    const JPEG = 'jpeg';
    const BMP = 'bmp';
    const GIF = 'gif';
    const PNG = 'png';
    const TIFF = 'tiff';
    const PSD = 'psd';

    const BZIP2 = 'bzip2';
    const GZIP = 'gzip';
    const LZMA2 = 'lzma2';
    const _7ZIP = '7z';
    const CAB = 'cab';
    const JAR = 'jar';
    const RAR = 'rar';
    const TAR = 'tar';
    const ZIP = 'zip';

    const MDB = 'mdb';
    const ODB = 'odb';

    const DOC = 'doc';
    const DOCX = 'docx';
    const HTML = 'html';
    const ODT = 'odt';
    const PDF = 'pdf';
    const RTF = 'rtf';
    const TXT = 'txt';
    const XML = 'xml';

    const OTF = 'otf';
    const TTF = 'ttf';

    const APK = 'apk';
    const COM = 'com';
    const EXE = 'exe';

    const PPT = 'ppt';
    const PPTX = 'pptx';
    const ODP = 'odp';

    const FLAC = 'flac';
    const WMA = 'wma';
    const AMR = 'amr';
    const MP3 = 'mp3';
    const AAC = 'aac';
    const M3U = 'm3u';
    const OGG = 'ogg';
    const WAV = 'wav';

    const ODS = 'ods';
    const XLS = 'xls';
    const XLSX = 'xlsx';

    const _3GP = '3gp';
    const ASF = 'asf';
    const AVI = 'avi';
    const FLV = 'flv';
    const M4V = 'm4v';
    const MKV = 'mkv';
    const MOV = 'mov';
    const MPEG = 'mpeg';
    const MP4 = 'mp4';
    const VOB = 'vob';
    const WMV = 'wmv';

    static protected $aliases = array(
        'jpg' => self::JPEG,
        'tif' => self::TIFF,
        'mpg' => self::MPEG,
        'mpe' => self::MPEG,
        'm4a' => self::AAC,
    );

    static protected $types = array(
        'jpeg' => array(self::IMAGE, self::JPEG),
        'bmp' => array(self::IMAGE, self::BMP),
        'gif' => array(self::IMAGE, self::GIF),
        'png' => array(self::IMAGE, self::PNG),
        'tiff' => array(self::IMAGE, self::TIFF),
        'psd' => array(self::IMAGE, self::PSD),
        'bz2' => array(self::ARCHIVE, self::BZIP2),
        'gz' => array(self::ARCHIVE, self::GZIP),
        'xz' => array(self::ARCHIVE, self::LZMA2),
        '7z' => array(self::ARCHIVE, self::_7ZIP),
        'cab' => array(self::ARCHIVE, self::CAB),
        'jar' => array(self::ARCHIVE, self::JAR),
        'rar' => array(self::ARCHIVE, self::RAR),
        'tar' => array(self::ARCHIVE, self::TAR),
        'zip' => array(self::ARCHIVE, self::ZIP),
        'mdb' => array(self::DATABASE, self::MDB),
        'odb' => array(self::DATABASE, self::ODB),
        'doc' => array(self::DOCUMENT, self::DOC),
        'docx' => array(self::DOCUMENT, self::DOCX),
        'html' => array(self::DOCUMENT, self::HTML),
        'odt' => array(self::DOCUMENT, self::ODT),
        'pdf' => array(self::DOCUMENT, self::PDF),
        'rtf' => array(self::DOCUMENT, self::RTF),
        'txt' => array(self::DOCUMENT, self::TXT),
        'xml' => array(self::DOCUMENT, self::XML),
        'otf' => array(self::FONT, self::OTF),
        'ttf' => array(self::FONT, self::TTF),
        'apk' => array(self::APPLICATION, self::APK),
        'com' => array(self::APPLICATION, self::COM),
        'exe' => array(self::APPLICATION, self::EXE),
        'ppt' => array(self::PRESENTATION, self::PPT),
        'pptx' => array(self::PRESENTATION, self::PPTX),
        'odp' => array(self::PRESENTATION, self::ODP),
        'flac' => array(self::AUDIO, self::FLAC),
        'wma' => array(self::AUDIO, self::WMA),
        'amr' => array(self::AUDIO, self::AMR),
        'mp3' => array(self::AUDIO, self::MP3),
        'aac' => array(self::AUDIO, self::AAC),
        'm3u' => array(self::AUDIO, self::M3U),
        'ogg' => array(self::AUDIO, self::OGG),
        'wav' => array(self::AUDIO, self::WAV),
        'ods' => array(self::SPREADSHEET, self::ODS),
        'xls' => array(self::SPREADSHEET, self::XLS),
        'xlsx' => array(self::SPREADSHEET, self::XLSX),
        '3gp' => array(self::VIDEO, self::_3GP),
        'asf' => array(self::VIDEO, self::ASF),
        'avi' => array(self::VIDEO, self::AVI),
        'flv' => array(self::VIDEO, self::FLV),
        'm4v' => array(self::VIDEO, self::M4V),
        'mkv' => array(self::VIDEO, self::MKV),
        'mov' => array(self::VIDEO, self::MOV),
        'mpeg' => array(self::VIDEO, self::MPEG),
        'mp4' => array(self::VIDEO, self::MP4),
        'vob' => array(self::VIDEO, self::VOB),
        'wmv' => array(self::VIDEO, self::WMV),
    );

    static protected $mimeTypes = array(
        self::JPEG => 'image/jpeg',
        self::BMP => 'image/bmp',
        self::GIF => 'image/gif',
        self::PNG => 'image/png',
        self::TIFF => 'image/tiff',
        self::PSD => 'image/vnd.adobe.photoshop',
        self::BZIP2 => 'application/x-bzip2',
        self::GZIP => 'application/gzip',
        self::_7ZIP => 'application/x-7z-compressed',
        self::LZMA2 => 'application/x-xz',
        self::CAB => 'application/vnd.ms-cab-compressed',
        self::JAR => 'application/java-archive',
        self::RAR => 'application/x-rar-compressed',
        self::TAR => 'application/x-tar',
        self::ZIP => 'application/zip',
        self::MDB => 'application/x-msaccess',
        self::ODB => 'application/vnd.oasis.opendocument.database',
        self::DOC => 'application/msword',
        self::DOCX => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        self::HTML => 'text/html',
        self::ODT => 'application/vnd.oasis.opendocument.text',
        self::PDF => 'application/pdf',
        self::RTF => 'application/rtf',
        self::TXT => 'text/plain',
        self::XML => 'application/xml',
        self::OTF => 'application/x-font-otf',
        self::TTF => 'application/x-font-ttf',
        self::APK => 'application/vnd.android.package-archive',
        self::COM => 'application/x-msdownload',
        self::EXE => 'application/x-msdownload',
        self::PPT => 'application/vnd.ms-powerpoint',
        self::PPTX => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        self::ODP => 'application/vnd.oasis.opendocument.presentation',
        self::FLAC => 'audio/x-flac',
        self::WMA => 'audio/x-ms-wma',
        self::AMR => 'audio/amr',
        self::MP3 => 'audio/mpeg',
        self::AAC => 'audio/x-aac',
        self::M3U => 'audio/x-mpegurl',
        self::OGG => 'audio/ogg',
        self::ODS => 'application/vnd.oasis.opendocument.spreadsheet',
        self::XLS => 'application/vnd.ms-excel',
        self::XLSX => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        self::_3GP => 'video/3gpp',
        self::AVI => 'video/x-msvideo',
        self::FLV => 'video/x-flv',
        self::M4V => 'video/x-m4v',
        self::MKV => 'video/x-matroska',
        self::MOV => 'video/quicktime',
        self::MPEG => 'video/mpeg',
        self::MP4 => 'video/mp4',
        self::VOB => 'video/x-ms-vob',
    );

    static public function detectByFilename($filename) {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (isset(self::$aliases[$ext])) $ext = self::$aliases[$ext];
        if (isset(self::$types[$ext])) return self::$types[$ext];
        return false;
    }

    static public function detectByContent($filename) {
        $stream = new ContentStream($filename);
        if ($stream->checkBytes(0, array(0xFF, 0xD8, 0xFF, 0xE0)))
            return array(self::IMAGE, self::JPEG);
        else if ($stream->checkBytes(0, array(0x42, 0x4D)))
            return array(self::IMAGE, self::BMP);
        else if ($stream->checkBytes(0, array(0x47, 0x49, 0x46, 0x38, 0x37, 0x61)) || $stream->checkBytes(0, array(0x47, 0x49, 0x46, 0x38, 0x39, 0x61)))
            return array(self::IMAGE, self::GIF);
        else if ($stream->checkBytes(0, array(0x89, 0x50, 0x4E, 0x47, 0x0D, 0x0A, 0x1A, 0x0A)))
            return array(self::IMAGE, self::PNG);
        else if ($stream->checkBytes(0, array(0x49, 0x49, 0x2A, 0x00)) || $stream->checkBytes(0, array(0x4D, 0x4D, 0x00, 0x2A)))
            return array(self::IMAGE, self::TIFF);
        else if ($stream->checkBytes(0, array(0x38, 0x42, 0x50, 0x53)))
            return array(self::IMAGE, self::PSD);
        else if ($stream->checkBytes(0, array(0x38, 0x42, 0x50, 0x53)))
            return array(self::IMAGE, self::PSD);

        else if ($stream->checkBytes(0, array(0x42, 0x5A, 0x68)))
            return array(self::ARCHIVE, self::BZIP2);
        else if ($stream->checkBytes(0, array(0x1F, 0x8B)))
            return array(self::ARCHIVE, self::GZIP);
        else if ($stream->checkBytes(0, array(0x37, 0x7A, 0xBC, 0xAF, 0x27, 0x1C)))
            return array(self::ARCHIVE, self::_7ZIP);
        else if ($stream->checkBytes(0, array(0x4D, 0x53, 0x43, 0x46)))
            return array(self::ARCHIVE, self::CAB);
        else if ($stream->checkBytes(0, array(0x52, 0x61, 0x72, 0x21, 0x1A, 0x07, 0x00)) || $stream->checkBytes(0, array(0x52, 0x61, 0x72, 0x21, 0x1A, 0x07, 0x01, 0x00)))
            return array(self::ARCHIVE, self::RAR);
        else if ($stream->checkBytes(0, array(0x75, 0x73, 0x74, 0x61, 0x72, 0x00, 0x30, 0x30)) || $stream->checkBytes(0, array(0x75, 0x73, 0x74, 0x61, 0x72, 0x20, 0x20, 0x00)))
            return array(self::ARCHIVE, self::TAR);

        else if ($stream->checkBytes(0, array(0x00, 0x01, 0x00, 0x00, 0x53, 0x74, 0x61, 0x6E, 0x64, 0x61, 0x72, 0x64, 0x20, 0x4A, 0x65, 0x74, 0x20, 0x44, 0x42)))
            return array(self::DATABASE, self::MDB);

        // MS-Office old formats
        else if ($stream->checkBytes(0, array(0xD0, 0xCF, 0x11, 0xE0, 0xA1, 0xB1, 0x1A, 0xE1))) {
            if ($stream->checkBytes(512, array(0xEC, 0xA5, 0xC1, 0x00)))
                return array(self::DOCUMENT, self::DOC);
            else if ($stream->checkBytes(512, array(0x09, 0x08, 0x10, 0x00, 0x00, 0x06, 0x05, 0x00)))
                return array(self::SPREADSHEET, self::XLS);
            else if ($stream->checkBytes(512, array(0xA0, 0x46, 0x1D, 0xF0)) ||
                $stream->checkBytes(512, array(0x00, 0x6E, 0x1E, 0xF0)) ||
                $stream->checkBytes(512, array(0x0F, 0x00, 0xE8, 0x03)))
                return array(self::PRESENTATION, self::PPT);
        }

        // MS-Office new formats
        else if ($stream->checkBytes(0, array(0x50, 0x4B, 0x03, 0x04, 0x14, 0x00, 0x06, 0x00))) {
            // using some hack to detect file format
            if ($stream->find(-22, array('w', 'o', 'r', 'd', '/'), 512, false))
                return array(self::DOCUMENT, self::DOCX);
            else if ($stream->find(-22, array('x', 'l', '/'), 512, false))
                return array(self::SPREADSHEET, self::XLSX);
            else if ($stream->find(-22, array('p', 'p', 't', '/'), 512, false))
                return array(self::PRESENTATION, self::PPTX);
        }

        else if ($stream->checkBytes(0, array('<', 'h', 't', 'm', 'l', '>')))
            return array(self::DOCUMENT, self::HTML);

        // open document formats
        else if ($stream->checkBytes(0, array(0x50, 0x4B, 0x03, 0x04)) && $stream->checkBytes(30, array('m', 'i', 'm', 'e',  't',  'y',  'p',  'e', 'a', 'p', 'p', 'l', 'i', 'c', 'a', 't', 'i', 'o', 'n', '/', 'v', 'n', 'd', '.', 'o', 'a', 's', 'i', 's', '.', 'o', 'p', 'e', 'n', 'd', 'o', 'c', 'u', 'm', 'e', 'n', 't', '.'))) {
            if ($stream->checkBytes(73, array('t', 'e', 'x', 't')))
                return array(self::DOCUMENT, self::ODT);
            else if ($stream->checkBytes(73, array('s', 'p', 'r', 'e', 'a', 'd', 's', 'h', 'e', 'e', 't')))
                return array(self::SPREADSHEET, self::ODS);
            else if ($stream->checkBytes(73, array('p', 'r', 'e', 's', 'e', 'n', 't', 'a', 't', 'i', 'o', 'n')))
                return array(self::PRESENTATION, self::ODP);
            else if ($stream->checkBytes(73, array('b', 'a', 's', 'e')))
                return array(self::DATABASE, self::ODB);
        }

        else if ($stream->checkBytes(0, array(0x25, 0x50, 0x44, 0x46)))
            return array(self::DOCUMENT, self::PDF);
        else if ($stream->checkBytes(0, array(0x7B, 0x5C, 0x72, 0x74, 0x66, 0x31)))
            return array(self::DOCUMENT, self::RTF);
        else if ($stream->checkBytes(0, array('<', '?', 'x', 'm', 'l')))
            return array(self::DOCUMENT, self::XML);

        else if ($stream->checkBytes(0, array(0x4F, 0x54, 0x54, 0x4F)))
            return array(self::FONT, self::OTF);
        else if ($stream->checkBytes(0, array(0x00, 0x01, 0x00, 0x00, 0x00)))
            return array(self::FONT, self::TTF);

        else if ($stream->checkBytes(0, array(0x50, 0x4B, 0x03, 0x04)) && $stream->checkBytes(30, array('A', 'n', 'd', 'r', 'o', 'i', 'd', 'M', 'a', 'n', 'i', 'f', 'e', 's', 't', '.', 'x', 'm', 'l')))
            return array(self::APPLICATION, self::APK);
        else if ($stream->checkBytes(0, array(0x4D, 0x5A)))
            return array(self::APPLICATION, self::EXE);

        else if ($stream->checkBytes(0, array(0x66, 0x4C, 0x61, 0x43, 0x00, 0x00, 0x00, 0x22)))
            return array(self::AUDIO, self::FLAC);
        else if ($stream->checkBytes(0, array(0x30, 0x26, 0xB2, 0x75, 0x8E, 0x66, 0xCF, 0x11, 0xA6, 0xD9, 0x00, 0xAA, 0x00, 0x62, 0xCE, 0x6C)))
            return array(self::AUDIO, self::WMA);
        else if ($stream->checkBytes(0, array(0x23, 0x21, 0x41, 0x4D, 0x52)))
            return array(self::AUDIO, self::AMR);
        else if ($stream->checkBytes(0, array(0x49, 0x44, 0x33)))
            return array(self::AUDIO, self::MP3);
        else if ($stream->checkBytes(0, array(0xFF, 0xF1)) || $stream->checkBytes(0, array(0xFF, 0xF9)))
            return array(self::AUDIO< self::AAC);
        else if ($stream->checkBytes(0, array('#', 'E', 'X', 'T', 'M', '3', 'U')))
            return array(self::AUDIO, self::M3U);
        else if ($stream->checkBytes(0, array('O', 'g', 'g', 'S')))
            return array(self::AUDIO, self::OGG);

        else if ($stream->checkBytes(0, array(0x00, 0x00, 0x00, 0x14, 0x66, 0x74, 0x79, 0x70, 0x33, 0x67, 0x70)))
            return array(self::VIDEO, self::_3GP);
        else if ($stream->checkBytes(0, array(0x52, 0x49, 0x46, 0x46)) && $stream->checkBytes(8, array(0x41, 0x56, 0x49, 0x20, 0x4C, 0x49, 0x53, 0x54)))
            return array(self::VIDEO, self::AVI);
        else if ($stream->checkBytes(0, array(0x46, 0x4C, 0x56, 0x01)))
            return array(self::VIDEO, self::FLV);
        else if ($stream->checkBytes(0, array(0x00, 0x00, 0x00, 0x18, 0x66, 0x74, 0x79, 0x70, 0x6D, 0x70, 0x34, 0x32)))
            return array(self::VIDEO, self::M4V);
        else if ($stream->checkBytes(0, array(0x1A, 0x45, 0xDF, 0xA3, 0x93, 0x42, 0x82, 0x88, 0x6D, 0x61, 0x74, 0x72, 0x6F, 0x73, 0x6B, 0x61)))
            return array(self::VIDEO, self::MKV);
        else if ($stream->checkBytes(4, array(0x66, 0x74, 0x79, 0x70, 0x71, 0x74, 0x20, 0x20)) || $stream->checkBytes(4, array(0x6D, 0x6F, 0x6F, 0x76)))
            return array(self::VIDEO, self::MOV);
        else if ($stream->checkBytes(0, array(0x00, 0x00, 0x01)) && $stream->checkBytes(-4, array(0x00, 0x00, 0x01, 0xB7)))
            return array(self::VIDEO, self::MPEG);
        else if ($stream->checkBytes(0, array(0x00, 0x00, 0x01, 0xBA)) && $stream->checkBytes(-4, array(0x00, 0x00, 0x01, 0xB9)))
            return array(self::VIDEO, self::VOB);


        // general ZIP format at the end because other formats use ZIP as container
        else if ($stream->checkBytes(0, array(0x50, 0x4B, 0x03, 0x04)) || $stream->checkBytes(0, array(0x50, 0x4B, 0x05, 0x06)) || $stream->checkBytes(0, array(0x50, 0x4B, 0x07, 0x08)))
            return array(self::ARCHIVE, self::ZIP);

        return false;
    }

    static public function getMimeType($format) {
        if (!isset(self::$mimeTypes[$format]))
            return false;
        return self::$mimeTypes[$format];
    }
}
