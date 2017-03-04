# FileTypeDetector
Files type detector based on file name extension or file content (binary content).

[![Composer package](http://xn--e1adiijbgl.xn--p1acf/badge/wapmorgan/file-type-detector)](https://packagist.org/packages/wapmorgan/file-type-detector)
[![Latest Stable Version](https://poser.pugx.org/wapmorgan/file-type-detector/v/stable)](https://packagist.org/packages/wapmorgan/file-type-detector)
[![Total Downloads](https://poser.pugx.org/wapmorgan/file-type-detector/downloads)](https://packagist.org/packages/wapmorgan/file-type-detector)
[![Latest Unstable Version](https://poser.pugx.org/wapmorgan/file-type-detector/v/unstable)](https://packagist.org/packages/wapmorgan/file-type-detector)
[![License](https://poser.pugx.org/wapmorgan/file-type-detector/license)](https://packagist.org/packages/wapmorgan/file-type-detector)

1. Usage
2. Installation
3. Supported formats

# Usage

## File Type detection

- Detection by filename: `Detector::detectByFilename(...filename...)`
- Detection by content: `Detector::detectByContent(...filename/resource...)`

Example:

```php
$type = wapmorgan\FileTypeDetector\Detector::detectByFilename($filename);

// $type will contain file type as an array like this:
// array(
//   Detector::AUDIO,
//   Detector::MP3
// )
// In case of failure it will contain `false`.


$type = wapmorgan\FileTypeDetector\Detector::detectByContent('file-without-extension');
// or
$type = wapmorgan\FileTypeDetector\Detector::detectByContent(fopen('http://somedomain/somepath', 'r'));
```

## Mimetype generation

To use correct mimetype for file there is `getMimeType($type)` function.

```php
$mime = wapmorgan\FileTypeDetector\Detector::getMimeType($type[1]);
// or
$mime = wapmorgan\FileTypeDetector\Detector::getMimeType(wapmorgan\FileTypeDetector\Detector::MP3); // audio/mpeg
```

# Installation
Install package via composer:
```
composer require wapmorgan/file-type-detector
```

# Supported formats

| Multimedia                   | Office documents                     | System files                     | Other files                    |
|------------------------------|--------------------------------------|----------------------------------|--------------------------------|
| **Images**                   | **Databases**                        | **Fonts**                        | **Archives**                   |
| `Detector::JPEG` - **.jpeg** | `Detector::MDB` - **.mdb**           | `Detector::OTF` - **.otf**       | `Detector::BZIP2` - **.bzip2** |
| `Detector::BMP` - **.bmp**   | `Detector::ODB` - **.odb**           | `Detector::TTF` - **.ttf**       | `Detector::GZIP` - **.gzip**   |
| `Detector::GIF` - **.gif**   | **Spreadsheets**                     | **Executables and applications** | `Detector::LZMA2` - **.lzma2** |
| `Detector::PNG` - **.png**   | `Detector::ODS` - **.ods**           | `Detector::APK` - **.apk**       | `Detector::_7ZIP` - **.7z**    |
| `Detector::TIFF` - **.tiff** | `Detector::XLS` - **.xls**           | `Detector::COM` - **.com**       | `Detector::CAB` - **.cab**     |
| `Detector::PSD` - **.psd**   | `Detector::XLSX` - **.xlsx**         | `Detector::EXE` - **.exe**       | `Detector::JAR` - **.jar**     |
| **Videos**                   | `Detector::CSV` - **.csv**           |                                  | `Detector::RAR` - **.rar**     |
| `Detector::_3GP` - **.3gp**  | **Text and documents**               |                                  | `Detector::TAR` - **.tar**     |
| `Detector::ASF` - **.asf**   | `Detector::DOC` - **.doc**           |                                  | `Detector::ZIP` - **.zip**     |
| `Detector::AVI` - **.avi**   | `Detector::DOCX` - **.docx**         |                                  | `Detector::ISO` - **.iso**     |
| `Detector::FLV` - **.flv**   | `Detector::HTML` - **.html**         |                                  | **Interned feeds**             |
| `Detector::M4V` - **.m4v**   | `Detector::ODT` - **.odt**           |                                  | `Detector::ATOM` - **.atom**   |
| `Detector::MKV` - **.mkv**   | `Detector::PDF` - **.pdf**           |                                  | `Detector::RSS` - **.rss**     |
| `Detector::MOV` - **.mov**   | `Detector::RTF` - **.rtf**           |                                  |                                |
| `Detector::MPEG` - **.mpeg** | `Detector::TXT` - **.txt**           |                                  |                                |
| `Detector::MP4` - **.mp4**   | `Detector::XML` - **.xml**           |                                  |                                |
| `Detector::VOB` - **.vob**   | `Detector::MARKDOWN` - **.markdown** |                                  |                                |
| **Audios**                   | `Detector::JSON` - **.json**         |                                  |                                |
| `Detector::FLAC` - **.flac** | `Detector::YAML` - **.yaml**         |                                  |                                |
| `Detector::WMA` - **.wma**   | **Presentations**                    |                                  |                                |
| `Detector::AMR` - **.amr**   | `Detector::PPT` - **.ppt**           |                                  |                                |
| `Detector::MP3` - **.mp3**   | `Detector::PPTX` - **.pptx**         |                                  |                                |
| `Detector::AAC` - **.aac**   | `Detector::ODP` - **.odp**           |                                  |                                |
| `Detector::M3U` - **.m3u**   |          |                           |                                  |                                |
| `Detector::OGG` - **.ogg**   |                                      |                                  |                                |
| `Detector::WAV` - **.wav**   |                                      |                                  |                                |
