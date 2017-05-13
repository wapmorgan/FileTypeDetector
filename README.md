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

| Image | Archive | Database | Document | Feed | Font | Application | Presentation | Audio | Spreadsheet | Video | Scenario |
|-------|---------|----------|----------|------|------|-------------|--------------|-------|-------------|-------|----------|
| jpeg  | arj     | accdb    | doc      | atom | otf  | apk         | ppt          | flac  | ods         | 3gp   | reg      |
| bmp   | bzip2   | mdb      | docx     | rss  | ttf  | com         | pptx         | wma   | xls         | asf   |          |
| gif   | gzip    | odb      | html     |      |      | exe         | odp          | amr   | xlsx        | avi   |          |
| png   | lzma2   | sqlite   | odt      |      |      |             |              | mp3   | csv         | flv   |          |
| tiff  | 7z      |          | pdf      |      |      |             |              | aac   | tsv         | m4v   |          |
| psd   | cab     |          | rtf      |      |      |             |              | m3u   |             | mkv   |          |
| ico   | jar     |          | txt      |      |      |             |              | ogg   |             | mov   |          |
|       | rar     |          | markdown |      |      |             |              | wav   |             | mpeg  |          |
|       | tar     |          | json     |      |      |             |              | midi  |             | mp4   |          |
|       | zip     |          | yaml     |      |      |             |              |       |             | swf   |          |
|       | iso     |          | xml      |      |      |             |              |       |             | vob   |          |
|       | arc     |          |          |      |      |             |              |       |             | wmv   |          |
|       | dar     |          |          |      |      |             |              |       |             | webm  |          |

Formats support status.

| Format   | Extension | Detection by content | MimeType                                                                  |
|----------|-----------|----------------------|---------------------------------------------------------------------------|
| Jpeg     | jpeg      | +                    | image/jpeg                                                                |
| Bmp      | bmp       | +                    | image/bmp                                                                 |
| Gif      | gif       | +                    | image/gif                                                                 |
| Png      | png       | +                    | image/png                                                                 |
| Tiff     | tiff      | +                    | image/tiff                                                                |
| Psd      | psd       | +                    | image/vnd.adobe.photoshop                                                 |
| Ico      | ico       | +                    | image/x-icon                                                              |
| Arj      | arj       | +                    | application/arj                                                           |
| Bzip2    | bz2       | +                    | application/x-bzip2                                                       |
| Gzip     | gz        | +                    | application/gzip                                                          |
| Lzma2    | xz        | -                    | application/x-xz                                                          |
| 7z       | 7z        | +                    | application/x-7z-compressed                                               |
| Cab      | cab       | +                    | application/vnd.ms-cab-compressed                                         |
| Jar      | jar       | +                    | application/java-archive                                                  |
| Rar      | rar       | +                    | application/x-rar-compressed                                              |
| Tar      | tar       | +                    | application/x-tar                                                         |
| Zip      | zip       | +                    | application/zip                                                           |
| Iso      | iso       | +                    | application/x-iso9660-image                                               |
| Arc      | arc       | +                    | application/x-freearc                                                     |
| Dar      | dar       | +                    | application/x-dar                                                         |
| Accdb    | accdb     | +                    | application/x-msaccess                                                    |
| Mdb      | mdb       | +                    | application/x-msaccess                                                    |
| Odb      | odb       | +                    | application/vnd.oasis.opendocument.database                               |
| Doc      | doc       | +                    | application/msword                                                        |
| Docx     | docx      | +                    | application/vnd.openxmlformats-officedocument.wordprocessingml.document   |
| Html     | html      | +                    | text/html                                                                 |
| Odt      | odt       | +                    | application/vnd.oasis.opendocument.text                                   |
| Pdf      | pdf       | +                    | application/pdf                                                           |
| Rtf      | rtf       | +                    | application/rtf                                                           |
| Txt      | txt       | -                    | text/plain                                                                |
| Markdown | md        | -                    | text/markdown                                                             |
| Json     | json      | -                    | application/json                                                          |
| Yaml     | yaml      | -                    | text/yaml                                                                 |
| Xml      | xml       | +                    | application/xml                                                           |
| Atom     | atom      | +                    | application/atom+xml                                                      |
| Rss      | rss       | +                    | application/rss+xml                                                       |
| Otf      | otf       | +                    | application/x-font-otf                                                    |
| Ttf      | ttf       | +                    | application/x-font-ttf                                                    |
| Apk      | apk       | +                    | application/vnd.android.package-archive                                   |
| Com      | com       | -                    | application/x-msdownload                                                  |
| Exe      | exe       | +                    | application/x-msdownload                                                  |
| Ppt      | ppt       | +                    | application/vnd.ms-powerpoint                                             |
| Pptx     | pptx      | +                    | application/vnd.openxmlformats-officedocument.presentationml.presentation |
| Odp      | odp       | +                    | application/vnd.oasis.opendocument.presentation                           |
| Flac     | flac      | +                    | audio/x-flac                                                              |
| Wma      | wma       | -                    | audio/x-ms-wma                                                            |
| Amr      | amr       | +                    | audio/amr                                                                 |
| Mp3      | mp3       | +                    | audio/mpeg                                                                |
| Aac      | aac       | +                    | audio/x-aac                                                               |
| M3u      | m3u       | +                    | audio/x-mpegurl                                                           |
| Ogg      | ogg       | +                    | audio/ogg                                                                 |
| Wav      | wav       | -                    | audio/x-wav                                                               |
| Midi     | midi      | +                    | audio/midi                                                                |
| Ods      | ods       | +                    | application/vnd.oasis.opendocument.spreadsheet                            |
| Xls      | xls       | +                    | application/vnd.ms-excel                                                  |
| Xlsx     | xlsx      | +                    | application/vnd.openxmlformats-officedocument.spreadsheetml.sheet         |
| Csv      | csv       | -                    | text/csv                                                                  |
| Tsv      | tsv       | -                    | text/tab-separated-values                                                 |
| 3gp      | 3gp       | +                    | video/3gpp                                                                |
| Asf      | asf       | -                    | -                                                                         |
| Avi      | avi       | +                    | video/x-msvideo                                                           |
| Flv      | flv       | +                    | video/x-flv                                                               |
| M4v      | m4v       | +                    | video/x-m4v                                                               |
| Mkv      | mkv       | +                    | video/x-matroska                                                          |
| Mov      | mov       | +                    | video/quicktime                                                           |
| Mpeg     | mpeg      | +                    | video/mpeg                                                                |
| Mp4      | mp4       | +                    | video/mp4                                                                 |
| Swf      | swf       | +                    | application/x-shockwave-flash                                             |
| Vob      | vob       | +                    | video/x-ms-vob                                                            |
| Wmv      | wmv       | -                    | video/x-ms-wmv                                                            |
| Webm     | webm      | +                    | video/webm                                                                |
| Reg      | reg       | +                    | text/plain                                                                |
