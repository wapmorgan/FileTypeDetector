# FileTypeDetector
Files type detector based on file name extension or file content (binary content).

[![Composer package](http://xn--e1adiijbgl.xn--p1acf/badge/wapmorgan/file-type-detector)](https://packagist.org/packages/wapmorgan/file-type-detector)
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
| 3gp      | 0         | +                    | video/3gpp                                                                | at [0]: (0x0001466747970336770)                                                                                                                                        |
| 7z       | 1         | +                    | application/x-7z-compressed                                               | at [0]: (0x377abcaf271c)                                                                                                                                               |
| Aac      | 2         | +                    | audio/x-aac                                                               | at [0]: (0xfff1)  / at [0]: (0xfff9)                                                                                                                                   |
| Accdb    | 3         | +                    | application/x-msaccess                                                    | at [0]: (0x01005374616e6461726420414345204442)                                                                                                                         |
| Amr      | 4         | +                    | audio/amr                                                                 | at [0]: (0x2321414d52)                                                                                                                                                 |
| Apk      | 5         | +                    | application/vnd.android.package-archive                                   | at [0]: (0x504b34)  & at [30]: ('AndroidManifest.xml')                                                                                                                 |
| Arc      | 6         | +                    | application/x-freearc                                                     | at [0]: (0x4172431)                                                                                                                                                    |
| Arj      | 7         | +                    | application/arj                                                           | at [0]: (0x60ea)                                                                                                                                                       |
| Asf      | 8         | -                    | -                                                                         |                                                                                                                                                                        |
| Atom     | 9         | +                    | application/atom+xml                                                      | at [0]: ('<?xml')  & at [10]: (fuzzy search 'Atom')                                                                                                                    |
| Avi      | 10        | +                    | video/x-msvideo                                                           | at [0]: (0x52494646)  & at [8]: (0x415649204c495354)                                                                                                                   |
| Bmp      | 11        | +                    | image/bmp                                                                 | at [0]: (0x424d)                                                                                                                                                       |
| Bzip2    | 12        | +                    | application/x-bzip2                                                       | at [0]: (0x425a68)                                                                                                                                                     |
| Cab      | 13        | +                    | application/vnd.ms-cab-compressed                                         | at [0]: (0x4d534346)                                                                                                                                                   |
| Com      | 14        | -                    | application/x-msdownload                                                  |                                                                                                                                                                        |
| Csv      | 15        | -                    | text/csv                                                                  |                                                                                                                                                                        |
| Dar      | 16        | +                    | application/x-dar                                                         | at [0]: (0x0007b)                                                                                                                                                      |
| Doc      | 17        | +                    | application/msword                                                        | at [0]: (0xd0cf11e0a1b11ae1)  & at [512]: (0xeca5c10)                                                                                                                  |
| Docx     | 18        | +                    | application/vnd.openxmlformats-officedocument.wordprocessingml.document   | at [0]: (0x504b3414060)  & at [-22]: (fuzzy search 'word/')                                                                                                            |
| Exe      | 19        | +                    | application/x-msdownload                                                  | at [0]: (0x4d5a)                                                                                                                                                       |
| Flac     | 20        | +                    | audio/x-flac                                                              | at [0]: (0x664c614300022)                                                                                                                                              |
| Flv      | 21        | +                    | video/x-flv                                                               | at [0]: (0x464c561)                                                                                                                                                    |
| Gif      | 22        | +                    | image/gif                                                                 | at [0]: (0x474946383761)  / at [0]: (0x474946383961)                                                                                                                   |
| Gzip     | 23        | +                    | application/gzip                                                          | at [0]: (0x1f8b)                                                                                                                                                       |
| Html     | 24        | +                    | text/html                                                                 | at [0]: ('<html')                                                                                                                                                      |
| Ico      | 25        | +                    | image/x-icon                                                              | at [0]: (0x0010)                                                                                                                                                       |
| Iso      | 26        | +                    | application/x-iso9660-image                                               | at [0]: (0x4344303031)                                                                                                                                                 |
| Jar      | 27        | +                    | application/java-archive                                                  | at [0]: (0x504b341408080)  / at [0]: (0x5f27a889)                                                                                                                      |
| Jpeg     | 28        | +                    | image/jpeg                                                                | at [0]: (0xffd8ffe0)                                                                                                                                                   |
| Json     | 29        | -                    | application/json                                                          |                                                                                                                                                                        |
| Lzma2    | 30        | -                    | application/x-xz                                                          |                                                                                                                                                                        |
| M3u      | 31        | +                    | audio/x-mpegurl                                                           | at [0]: ('#EXTM3U')                                                                                                                                                    |
| M4v      | 32        | +                    | video/x-m4v                                                               | at [0]: (0x00018667479706d703432)                                                                                                                                      |
| Markdown | 33        | -                    | text/markdown                                                             |                                                                                                                                                                        |
| Mdb      | 34        | +                    | application/x-msaccess                                                    | at [0]: (0x01005374616e64617264204a6574204442)                                                                                                                         |
| Midi     | 35        | +                    | audio/midi                                                                | at [0]: (0x4d546864)                                                                                                                                                   |
| Mkv      | 36        | +                    | video/x-matroska                                                          | at [0]: (0x1a45dfa3934282886d6174726f736b61)                                                                                                                           |
| Mov      | 37        | +                    | video/quicktime                                                           | at [4]: (0x6674797071742020)  / at [4]: (0x6d6f6f76)                                                                                                                   |
| Mp3      | 38        | +                    | audio/mpeg                                                                | at [0]: (0x494433)                                                                                                                                                     |
| Mp4      | 39        | +                    | video/mp4                                                                 | at [4]: (0x6674797069736f6d)  / at [4]: (0x6674797033677035)  / at [4]: (0x667479704d534e56)  / at [4]: (0x667479704d344120)                                           |
| Mpeg     | 40        | +                    | video/mpeg                                                                | at [0]: (0x001)  & at [-4]: (0x001b7)                                                                                                                                  |
| Nrg      | 41        | +                    | -                                                                         | at [-8]: ('NERO')  / at [-12]: ('NER5')                                                                                                                                |
| Odb      | 42        | +                    | application/vnd.oasis.opendocument.database                               | at [0]: (0x504b34)  & at [30]: ('mimetypeapplication/vnd.oasis.opendocument.')  & at [73]: ('base')                                                                    |
| Odp      | 43        | +                    | application/vnd.oasis.opendocument.presentation                           | at [0]: (0x504b34)  & at [30]: ('mimetypeapplication/vnd.oasis.opendocument.')  & at [73]: ('presentation')                                                            |
| Ods      | 44        | +                    | application/vnd.oasis.opendocument.spreadsheet                            | at [0]: (0x504b34)  & at [30]: ('mimetypeapplication/vnd.oasis.opendocument.')  & at [73]: ('spreadsheet')                                                             |
| Odt      | 45        | +                    | application/vnd.oasis.opendocument.text                                   | at [0]: (0x504b34)  & at [30]: ('mimetypeapplication/vnd.oasis.opendocument.')  & at [73]: ('text')                                                                    |
| Ogg      | 46        | +                    | audio/ogg                                                                 | at [0]: ('OggS')                                                                                                                                                       |
| Otf      | 47        | +                    | application/x-font-otf                                                    | at [0]: (0x4f54544f)                                                                                                                                                   |
| Pdf      | 48        | +                    | application/pdf                                                           | at [0]: (0x25504446)                                                                                                                                                   |
| Png      | 49        | +                    | image/png                                                                 | at [0]: (0x89504e47da1aa)                                                                                                                                              |
| Ppt      | 50        | +                    | application/vnd.ms-powerpoint                                             | at [0]: (0xd0cf11e0a1b11ae1)  & at [512]: (0xa0461df0)  / at [0]: (0xd0cf11e0a1b11ae1)  & at [512]: (0x06e1ef0)  / at [0]: (0xd0cf11e0a1b11ae1)  & at [512]: (0xf0e83) |
| Pptx     | 51        | +                    | application/vnd.openxmlformats-officedocument.presentationml.presentation | at [0]: (0x504b3414060)  & at [-22]: (fuzzy search 'ppt/')                                                                                                             |
| Psd      | 52        | +                    | image/vnd.adobe.photoshop                                                 | at [0]: (0x38425053)                                                                                                                                                   |
| Rar      | 53        | +                    | application/x-rar-compressed                                              | at [0]: (0x526172211a70)  / at [0]: (0x526172211a710)                                                                                                                  |
| Reg      | 54        | +                    | text/plain                                                                | at [0]: (0xfffe)  / at [0]: (0x52454745444954)                                                                                                                         |
| Rss      | 55        | +                    | application/rss+xml                                                       | at [0]: ('<?xml')  & at [10]: (fuzzy search '<rss')                                                                                                                    |
| Rtf      | 56        | +                    | application/rtf                                                           | at [0]: (0x7b5c72746631)                                                                                                                                               |
| Swf      | 57        | +                    | application/x-shockwave-flash                                             | at [0]: (0x5a5753)                                                                                                                                                     |
| Tar      | 58        | +                    | application/x-tar                                                         | at [0]: (0x757374617203030)  / at [0]: (0x757374617220200)                                                                                                             |
| Tiff     | 59        | +                    | image/tiff                                                                | at [0]: (0x492049)  / at [0]: (0x49492a0)  / at [0]: (0x4d4d02a)  / at [0]: (0x4d4d02b)                                                                                |
| Tsv      | 60        | -                    | text/tab-separated-values                                                 |                                                                                                                                                                        |
| Ttf      | 61        | +                    | application/x-font-ttf                                                    | at [0]: (0x01000)                                                                                                                                                      |
| Txt      | 62        | -                    | text/plain                                                                |                                                                                                                                                                        |
| Vhd      | 63        | -                    | -                                                                         |                                                                                                                                                                        |
| Vob      | 64        | +                    | video/x-ms-vob                                                            | at [0]: (0x001ba)  & at [-4]: (0x001b9)                                                                                                                                |
| Wav      | 65        | -                    | audio/x-wav                                                               |                                                                                                                                                                        |
| Webm     | 66        | +                    | video/webm                                                                | at [0]: (0x1a45dfa3)                                                                                                                                                   |
| Wma      | 67        | -                    | audio/x-ms-wma                                                            |                                                                                                                                                                        |
| Wmv      | 68        | -                    | video/x-ms-wmv                                                            |                                                                                                                                                                        |
| Xap      | 69        | -                    | application/x-silverlight-app                                             |                                                                                                                                                                        |
| Xls      | 70        | +                    | application/vnd.ms-excel                                                  | at [0]: (0xd0cf11e0a1b11ae1)  & at [512]: (0x981000650)                                                                                                                |
| Xlsx     | 71        | +                    | application/vnd.openxmlformats-officedocument.spreadsheetml.sheet         | at [0]: (0x504b3414060)  & at [-22]: (fuzzy search 'xl/')                                                                                                              |
| Xml      | 72        | +                    | application/xml                                                           | at [0]: ('<?xml')                                                                                                                                                      |
| Yaml     | 73        | -                    | text/yaml                                                                 |                                                                                                                                                                        |
| Zip      | 74        | +                    | application/zip                                                           | at [0]: (0x504b34)  / at [0]: (0x504b56)  / at [0]: (0x504b78)                                                                                                         |
