# FileTypeDetector
Files type detector based on file name extension or file content (binary content).

[![Latest Stable Version](https://poser.pugx.org/wapmorgan/file-type-detector/v/stable)](https://packagist.org/packages/wapmorgan/file-type-detector)
[![Total Downloads](https://poser.pugx.org/wapmorgan/file-type-detector/downloads)](https://packagist.org/packages/wapmorgan/file-type-detector)
[![Latest Unstable Version](https://poser.pugx.org/wapmorgan/file-type-detector/v/unstable)](https://packagist.org/packages/wapmorgan/file-type-detector)
[![License](https://poser.pugx.org/wapmorgan/file-type-detector/license)](https://packagist.org/packages/wapmorgan/file-type-detector)
[![Tests](https://travis-ci.org/wapmorgan/FileTypeDetector.svg?branch=master)](https://travis-ci.org/wapmorgan/FileTypeDetector)

1. Usage
2. Installation
3. Supported formats

# Usage

## File Type detection

- Detection by file name: `Detector::detectByFilename(...filename...): array|boolean`
- Detection by file content or stream content: `Detector::detectByContent(...filename/resource...): array|boolean`

Both functions will return an `array` with following elements in case of success:

- `[0]` - Type of file (`Detector::AUDIO` and so on)
- `[1]` - Format of file (`Detector::MP3` and so on)
- `[2]` - Mime type of file (`'audio/mpeg'` for example)

In case of failure it will return `false`.

Example:

```php
$type = wapmorgan\FileTypeDetector\Detector::detectByFilename($filename);
// or
$type = wapmorgan\FileTypeDetector\Detector::detectByContent('file-without-extension');
// or
$type = wapmorgan\FileTypeDetector\Detector::detectByContent(fopen('http://somedomain/somepath', 'r'));
```

## Mimetype generation

To get correct mimetype for file only there is `getMimeType($file)` function.

```php
$mime = wapmorgan\FileTypeDetector\Detector::getMimeType($file);
// or
$mime = wapmorgan\FileTypeDetector\Detector::getMimeType(fopen('somefile', 'r'));
```

# Installation
Install package via composer:
```
composer require wapmorgan/file-type-detector
```

# Supported formats

Available to use types and their formats.

| Application | Archive | Audio | Database | Disk_image | Document | Feed | Font | Image | Presentation | Scenario | Spreadsheet | Video |
|-------------|---------|-------|----------|------------|----------|------|------|-------|--------------|----------|-------------|-------|
| apk         | 7z      | aac   | accdb    | iso        | doc      | atom | otf  | bmp   | odp          | reg      | csv         | 3gp   |
| com         | arc     | amr   | mdb      | nrg        | docx     | rss  | ttf  | gif   | ppt          |          | ods         | asf   |
| exe         | arj     | flac  | odb      | vhd        | html     |      |      | ico   | pptx         |          | tsv         | avi   |
| xap         | bzip2   | m3u   | sqlite   |            | json     |      |      | jpeg  |              |          | xls         | flv   |
|             | cab     | midi  |          |            | markdown |      |      | png   |              |          | xlsx        | m4v   |
|             | dar     | mp3   |          |            | odt      |      |      | psd   |              |          |             | mkv   |
|             | gzip    | ogg   |          |            | pdf      |      |      | tiff  |              |          |             | mov   |
|             | jar     | wav   |          |            | rtf      |      |      |       |              |          |             | mp4   |
|             | lzma2   | wma   |          |            | txt      |      |      |       |              |          |             | mpeg  |
|             | rar     |       |          |            | xml      |      |      |       |              |          |             | swf   |
|             | tar     |       |          |            | yaml     |      |      |       |              |          |             | vob   |
|             | zip     |       |          |            |          |      |      |       |              |          |             | webm  |
|             |         |       |          |            |          |      |      |       |              |          |             | wmv   |

Formats support status.

| Format   | Extension | Detection by content | MimeType                                                                  | Signature                                                                                                                                                              |
|----------|-----------|----------------------|---------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 3gp      | 3gp       | +                    | video/3gpp                                                                | at [0]: (0x0001466747970336770)                                                                                                                                        |
| 7z       | 7z        | +                    | application/x-7z-compressed                                               | at [0]: (0x377abcaf271c)                                                                                                                                               |
| Aac      | aac       | +                    | audio/x-aac                                                               | at [0]: (0xfff1)  / at [0]: (0xfff9)                                                                                                                                   |
| Accdb    | accdb     | +                    | application/x-msaccess                                                    | at [0]: (0x01005374616e6461726420414345204442)                                                                                                                         |
| Amr      | amr       | +                    | audio/amr                                                                 | at [0]: (0x2321414d52)                                                                                                                                                 |
| Apk      | apk       | +                    | application/vnd.android.package-archive                                   | at [0]: (0x504b34)  & at [30]: ('AndroidManifest.xml')                                                                                                                 |
| Arc      | arc       | +                    | application/x-freearc                                                     | at [0]: (0x4172431)                                                                                                                                                    |
| Arj      | arj       | +                    | application/arj                                                           | at [0]: (0x60ea)                                                                                                                                                       |
| Asf      | asf       | -                    | -                                                                         |                                                                                                                                                                        |
| Atom     | atom      | +                    | application/atom+xml                                                      | at [0]: ('<?xml')  & at [10]: (fuzzy search 'Atom')                                                                                                                    |
| Avi      | avi       | +                    | video/x-msvideo                                                           | at [0]: (0x52494646)  & at [8]: (0x415649204c495354)                                                                                                                   |
| Bmp      | bmp       | +                    | image/bmp                                                                 | at [0]: (0x424d)                                                                                                                                                       |
| Bzip2    | bz2       | +                    | application/x-bzip2                                                       | at [0]: (0x425a68)                                                                                                                                                     |
| Cab      | cab       | +                    | application/vnd.ms-cab-compressed                                         | at [0]: (0x4d534346)                                                                                                                                                   |
| Com      | com       | -                    | application/x-msdownload                                                  |                                                                                                                                                                        |
| Csv      | csv       | -                    | text/csv                                                                  |                                                                                                                                                                        |
| Dar      | dar       | +                    | application/x-dar                                                         | at [0]: (0x0007b)                                                                                                                                                      |
| Doc      | doc       | +                    | application/msword                                                        | at [0]: (0xd0cf11e0a1b11ae1)  & at [512]: (0xeca5c10)                                                                                                                  |
| Docx     | docx      | +                    | application/vnd.openxmlformats-officedocument.wordprocessingml.document   | at [0]: (0x504b3414060)  & at [-22]: (fuzzy search 'word/')                                                                                                            |
| Exe      | exe       | +                    | application/x-msdownload                                                  | at [0]: (0x4d5a)                                                                                                                                                       |
| Flac     | flac      | +                    | audio/x-flac                                                              | at [0]: (0x664c614300022)                                                                                                                                              |
| Flv      | flv       | +                    | video/x-flv                                                               | at [0]: (0x464c561)                                                                                                                                                    |
| Gif      | gif       | +                    | image/gif                                                                 | at [0]: (0x474946383761)  / at [0]: (0x474946383961)                                                                                                                   |
| Gzip     | gz        | +                    | application/gzip                                                          | at [0]: (0x1f8b)                                                                                                                                                       |
| Html     | html      | +                    | text/html                                                                 | at [0]: ('<html')                                                                                                                                                      |
| Ico      | ico       | +                    | image/x-icon                                                              | at [0]: (0x0010)                                                                                                                                                       |
| Iso      | iso       | +                    | application/x-iso9660-image                                               | at [0]: (0x4344303031)                                                                                                                                                 |
| Jar      | jar       | +                    | application/java-archive                                                  | at [0]: (0x504b341408080)  / at [0]: (0x5f27a889)                                                                                                                      |
| Jpeg     | jpeg      | +                    | image/jpeg                                                                | at [0]: (0xffd8ffe0)                                                                                                                                                   |
| Json     | json      | -                    | application/json                                                          |                                                                                                                                                                        |
| Lzma2    | xz        | -                    | application/x-xz                                                          |                                                                                                                                                                        |
| M3u      | m3u       | +                    | audio/x-mpegurl                                                           | at [0]: ('#EXTM3U')                                                                                                                                                    |
| M4v      | m4v       | +                    | video/x-m4v                                                               | at [0]: (0x00018667479706d703432)                                                                                                                                      |
| Markdown | md        | -                    | text/markdown                                                             |                                                                                                                                                                        |
| Mdb      | mdb       | +                    | application/x-msaccess                                                    | at [0]: (0x01005374616e64617264204a6574204442)                                                                                                                         |
| Midi     | midi      | +                    | audio/midi                                                                | at [0]: (0x4d546864)                                                                                                                                                   |
| Mkv      | mkv       | +                    | video/x-matroska                                                          | at [0]: (0x1a45dfa3934282886d6174726f736b61)                                                                                                                           |
| Mov      | mov       | +                    | video/quicktime                                                           | at [4]: (0x6674797071742020)  / at [4]: (0x6d6f6f76)                                                                                                                   |
| Mp3      | mp3       | +                    | audio/mpeg                                                                | at [0]: (0x494433)                                                                                                                                                     |
| Mp4      | mp4       | +                    | video/mp4                                                                 | at [4]: (0x6674797069736f6d)  / at [4]: (0x6674797033677035)  / at [4]: (0x667479704d534e56)  / at [4]: (0x667479704d344120)                                           |
| Mpeg     | mpeg      | +                    | video/mpeg                                                                | at [0]: (0x001)  & at [-4]: (0x001b7)                                                                                                                                  |
| Nrg      | nrg       | +                    | -                                                                         | at [-8]: ('NERO')  / at [-12]: ('NER5')                                                                                                                                |
| Odb      | odb       | +                    | application/vnd.oasis.opendocument.database                               | at [0]: (0x504b34)  & at [30]: ('mimetypeapplication/vnd.oasis.opendocument.')  & at [73]: ('base')                                                                    |
| Odp      | odp       | +                    | application/vnd.oasis.opendocument.presentation                           | at [0]: (0x504b34)  & at [30]: ('mimetypeapplication/vnd.oasis.opendocument.')  & at [73]: ('presentation')                                                            |
| Ods      | ods       | +                    | application/vnd.oasis.opendocument.spreadsheet                            | at [0]: (0x504b34)  & at [30]: ('mimetypeapplication/vnd.oasis.opendocument.')  & at [73]: ('spreadsheet')                                                             |
| Odt      | odt       | +                    | application/vnd.oasis.opendocument.text                                   | at [0]: (0x504b34)  & at [30]: ('mimetypeapplication/vnd.oasis.opendocument.')  & at [73]: ('text')                                                                    |
| Ogg      | ogg       | +                    | audio/ogg                                                                 | at [0]: ('OggS')                                                                                                                                                       |
| Otf      | otf       | +                    | application/x-font-otf                                                    | at [0]: (0x4f54544f)                                                                                                                                                   |
| Pdf      | pdf       | +                    | application/pdf                                                           | at [0]: (0x25504446)                                                                                                                                                   |
| Png      | png       | +                    | image/png                                                                 | at [0]: (0x89504e47da1aa)                                                                                                                                              |
| Ppt      | ppt       | +                    | application/vnd.ms-powerpoint                                             | at [0]: (0xd0cf11e0a1b11ae1)  & at [512]: (0xa0461df0)  / at [0]: (0xd0cf11e0a1b11ae1)  & at [512]: (0x06e1ef0)  / at [0]: (0xd0cf11e0a1b11ae1)  & at [512]: (0xf0e83) |
| Pptx     | pptx      | +                    | application/vnd.openxmlformats-officedocument.presentationml.presentation | at [0]: (0x504b3414060)  & at [-22]: (fuzzy search 'ppt/')                                                                                                             |
| Psd      | psd       | +                    | image/vnd.adobe.photoshop                                                 | at [0]: (0x38425053)                                                                                                                                                   |
| Rar      | rar       | +                    | application/x-rar-compressed                                              | at [0]: (0x526172211a70)  / at [0]: (0x526172211a710)                                                                                                                  |
| Reg      | reg       | +                    | text/plain                                                                | at [0]: (0xfffe)  / at [0]: (0x52454745444954)                                                                                                                         |
| Rss      | rss       | +                    | application/rss+xml                                                       | at [0]: ('<?xml')  & at [10]: (fuzzy search '<rss')                                                                                                                    |
| Rtf      | rtf       | +                    | application/rtf                                                           | at [0]: (0x7b5c72746631)                                                                                                                                               |
| Swf      | swf       | +                    | application/x-shockwave-flash                                             | at [0]: (0x5a5753)                                                                                                                                                     |
| Tar      | tar       | +                    | application/x-tar                                                         | at [0]: (0x757374617203030)  / at [0]: (0x757374617220200)                                                                                                             |
| Tiff     | tiff      | +                    | image/tiff                                                                | at [0]: (0x492049)  / at [0]: (0x49492a0)  / at [0]: (0x4d4d02a)  / at [0]: (0x4d4d02b)                                                                                |
| Tsv      | tsv       | -                    | text/tab-separated-values                                                 |                                                                                                                                                                        |
| Ttf      | ttf       | +                    | application/x-font-ttf                                                    | at [0]: (0x01000)                                                                                                                                                      |
| Txt      | txt       | -                    | text/plain                                                                |                                                                                                                                                                        |
| Vhd      | vhd       | -                    | -                                                                         |                                                                                                                                                                        |
| Vob      | vob       | +                    | video/x-ms-vob                                                            | at [0]: (0x001ba)  & at [-4]: (0x001b9)                                                                                                                                |
| Wav      | wav       | -                    | audio/x-wav                                                               |                                                                                                                                                                        |
| Webm     | webm      | +                    | video/webm                                                                | at [0]: (0x1a45dfa3)                                                                                                                                                   |
| Wma      | wma       | -                    | audio/x-ms-wma                                                            |                                                                                                                                                                        |
| Wmv      | wmv       | -                    | video/x-ms-wmv                                                            |                                                                                                                                                                        |
| Xap      | xap       | -                    | application/x-silverlight-app                                             |                                                                                                                                                                        |
| Xls      | xls       | +                    | application/vnd.ms-excel                                                  | at [0]: (0xd0cf11e0a1b11ae1)  & at [512]: (0x981000650)                                                                                                                |
| Xlsx     | xlsx      | +                    | application/vnd.openxmlformats-officedocument.spreadsheetml.sheet         | at [0]: (0x504b3414060)  & at [-22]: (fuzzy search 'xl/')                                                                                                              |
| Xml      | xml       | +                    | application/xml                                                           | at [0]: ('<?xml')                                                                                                                                                      |
| Yaml     | yaml      | -                    | text/yaml                                                                 |                                                                                                                                                                        |
| Zip      | zip       | +                    | application/zip                                                           | at [0]: (0x504b34)  / at [0]: (0x504b56)  / at [0]: (0x504b78)                                                                                                         |
