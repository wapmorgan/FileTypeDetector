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

    const ODS = 'ods';
    const XLS = 'xls';
    const XLSX = 'xlsx';

    const THREE_GP = '3gp';
    const AVI = 'avi';
    const FLV = 'flv';
    const M4V = 'm4v';
    const MKV = 'mkv';
    const MOV = 'mov';
    const MPEG = 'mpeg';
    const VOB = 'vob';

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

            case 'odb':
                return array(self::DATABASE, self::ODB);

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

            case 'xls':
                return array(self::SPREADSHEET, self::XLS);

            case 'xlsx':
                return array(self::SPREADSHEET, self::XLSX);

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

            case 'vob':
                return array(self::VIDEO, self::VOB);

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

        else if ($stream->checkBytes(0, array(0x50, 0x4B, 0x03, 0x04)) && $stream->checkBytes(30, array('A', 'n', 'd', 'r', 'o', 'i', 'd', 'M', 'a', 'n', 'i', 'f', 'e', 's', 't', '.x', 'm', 'l')))
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

        else if ($stream->checkBytes(0, array(0x00, 0x00, 0x00, 0x14, 0x66, 0x74, 0x79, 0x70, 0x33, 0x67, 0x70)))
            return array(self::VIDEO, self::THREE_GP);
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
}
