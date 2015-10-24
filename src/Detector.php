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
    const LZMA = 'lzma';
    const XZ = 'xz';
    const SEVEN_ZIP = '7z';
    const CAB = 'cab';
    const JAR = 'jar';
    const RAR = 'rar';
    const TAR = 'tar';
    const ZIP = 'zip';

    const MDB = 'mdb';

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
    const APP = 'app';
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

    const ODS = 'ods';
    const XLS = 'xls';

    const THREE_GP = '3gp';
    const AVI = 'avi';
    const FLV = 'flv';
    const M4V = 'm4v';
    const MKV = 'mkv';
    const MOV = 'mov';
    const MPEG = 'mpeg';

    static public function detectByFilename($filename) {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        switch ($ext) {
            case 'jpeg':
            case 'jpg':
                return array(self::IMAGE, self::JPEG);

            case 'bmp':
                return array(self::IMAGE, self::BMP);

            case 'gif':
                return array(self::IMAGE, self::GIF);

            case 'png':
                return array(self::IMAGE, self::PNG);

            case 'tiff':
                return array(self::IMAGE, self::TIFF);

            case 'psd':
                return array(self::IMAGE, self::PSD);

            case 'bz2':
                return array(self::ARCHIVE, self::BZIP2);

            case 'gz':
                return array(self::ARCHIVE, self::GZIP);

            case 'lzma':
                return array(self::ARCHIVE, self::LZMA);

            case 'xz':
                return array(self::ARCHIVE, self::XZ);

            case '7z':
                return array(self::ARCHIVE, self::SEVEN_ZIP);

            case 'cab':
                return array(self::ARCHIVE, self::CAB);

            case 'jar':
                return array(self::ARCHIVE, self::JAR);

            case 'rar':
                return array(self::ARCHIVE, self::RAR);

            case 'tar':
                return array(self::ARCHIVE, self::TAR);

            case 'zip':
                return array(self::ARCHIVE, self::ZIP);

            case 'mdb':
                return array(self::DATABASE, self::MBD);

            case 'doc':
                return array(self::DOCUMENT, self::DOC);

            case 'docx':
                return array(self::DOCUMENT, self::DOCX);

            case 'html':
                return array(self::DOCUMENT, self::HTML);

            case 'odt':
                return array(self::DOCUMENT, self::ODT);

            case 'pdf':
                return array(self::DOCUMENT, self::PDF);

            case 'rtf':
                return array(self::DOCUMENT, self::RTF);

            case 'txt':
                return array(self::DOCUMENT, self::TXT);

            case 'xml':
                return array(self::DOCUMENT, self::XML);

            case 'otf':
                return array(self::FONT, self::OTF);

            case 'ttf':
                return array(self::FONT, self::TTF);

            case 'apk':
                return array(self::APPLICATION, self::APK);

            case 'app':
                return array(self::APPLICATION, self::APP);

            case 'com':
                return array(self::APPLICATION, self::COM);

            case 'exe':
                return array(self::APPLICATION, self::EXE);

            case 'ppt':
                return array(self::PRESENTATION, self::PPT);

            case 'pptx':
                return array(self::PRESENTATION, self::PPTX);

            case 'odp':
                return array(self::PRESENTATION, self::ODP);

            case 'flac':
                return array(self::AUDIO, self::FLAC);

            case 'wma':
                return array(self::AUDIO, self::WMA);

            case 'amr':
                return array(self::AUDIO, self::AMR);

            case 'mp3':
                return array(self::AUDIO, self::MP3);

            case 'aac':
                return array(self::AUDIO, self::AAC);

            case 'm3u':
                return array(self::AUDIO, self::M3U);

            case 'ods':
                return array(self::SPREADSHEET, self::ODS);

            case 'csv':
                return array(self::SPREADSHEET);

            case 'xls':
                return array(self::SPREADSHEET, self::XLS);

            case '3gp':
                return array(self::VIDEO, self::THREE_GP);

            case 'avi':
                return array(self::VIDEO, self::AVI);

            case 'flv':
                return array(self::VIDEO, self::FLV);

            case 'm4v':
                return array(self::VIDEO, self::M4V);

            case 'mkv':
                return array(self::VIDEO, self::MKV);

            case 'mov':
                return array(self::VIDEO, self::MOV);

            case 'mpg':
            case 'mpe':
            case 'mpeg':
                return array(self::VIDEO, self::MPEG);

            default:
                return false;
        }
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
            return array(self::ARCHIVE, self::SEVEN_ZIP);
        else if ($stream->checkBytes(0, array(0x4D, 0x53, 0x43, 0x46)))
            return array(self::ARCHIVE, self::CAB);
        else if ($stream->checkBytes(0, array(0x52, 0x61, 0x72, 0x21, 0x1A, 0x07, 0x00)) || $stream->checkBytes(0, array(0x52, 0x61, 0x72, 0x21, 0x1A, 0x07, 0x01, 0x00)))
            return array(self::ARCHIVE, self::RAR);
        else if ($stream->checkBytes(0, array(0x75, 0x73, 0x74, 0x61, 0x72, 0x00, 0x30, 0x30)) || $stream->checkBytes(0, array(0x75, 0x73, 0x74, 0x61, 0x72, 0x20, 0x20, 0x00)))
            return array(self::ARCHIVE, self::TAR);
        else if ($stream->checkBytes(0, array(0x50, 0x4B, 0x03, 0x04)) || $stream->checkBytes(0, array(0x50, 0x4B, 0x05, 0x06)) || $stream->checkBytes(0, array(0x50, 0x4B, 0x07, 0x08)))
            return array(self::ARCHIVE, self::ZIP);

        else if ($stream->checkBytes(0, array(0x00, 0x01, 0x00, 0x00, 0x53, 0x74, 0x61, 0x6E, 0x64, 0x61, 0x72, 0x64, 0x20, 0x4A, 0x65, 0x74, 0x20, 0x44, 0x42)))
            return array(self::DATABASE, self::MDB);

        return false;
    }
}
