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
| `Detector::GIF` - **.gif**   |                                      |                                  | `Detector::LZMA2` - **.lzma2** |
| `Detector::PNG` - **.png**   | **Spreadsheets**                     | **Executables and applications** | `Detector::_7ZIP` - **.7z**    |
| `Detector::TIFF` - **.tiff** | `Detector::ODS` - **.ods**           | `Detector::APK` - **.apk**       | `Detector::CAB` - **.cab**     |
| `Detector::PSD` - **.psd**   | `Detector::XLS` - **.xls**           | `Detector::COM` - **.com**       | `Detector::JAR` - **.jar**     |
|                              | `Detector::XLSX` - **.xlsx**         | `Detector::EXE` - **.exe**       | `Detector::RAR` - **.rar**     |
| **Videos**                   | `Detector::CSV` - **.csv**           |                                  | `Detector::TAR` - **.tar**     |
| `Detector::_3GP` - **.3gp**  |                                      |                                  | `Detector::ZIP` - **.zip**     |
| `Detector::ASF` - **.asf**   | **Text and documents**               |                                  | `Detector::ISO` - **.iso**     |
| `Detector::AVI` - **.avi**   | `Detector::DOC` - **.doc**           |                                  |                                |
| `Detector::FLV` - **.flv**   | `Detector::DOCX` - **.docx**         |                                  | **Interned feeds**             |
| `Detector::M4V` - **.m4v**   | `Detector::HTML` - **.html**         |                                  | `Detector::ATOM` - **.atom**   |
| `Detector::MKV` - **.mkv**   | `Detector::ODT` - **.odt**           |                                  | `Detector::RSS` - **.rss**     |
| `Detector::MOV` - **.mov**   | `Detector::PDF` - **.pdf**           |                                  |                                |
| `Detector::MPEG` - **.mpeg** | `Detector::RTF` - **.rtf**           |                                  |                                |
| `Detector::MP4` - **.mp4**   | `Detector::TXT` - **.txt**           |                                  |                                |
| `Detector::VOB` - **.vob**   | `Detector::XML` - **.xml**           |                                  |                                |
| `Detector::WEBM` - **.webm** | `Detector::MARKDOWN` - **.markdown** |                                  |                                |
|                              | `Detector::JSON` - **.json**         |                                  |                                |
| **Audios**                   | `Detector::YAML` - **.yaml**         |                                  |                                |
| `Detector::FLAC` - **.flac** |                                      |                                  |                                |
| `Detector::WMA` - **.wma**   | **Presentations**                    |                                  |                                |
| `Detector::AMR` - **.amr**   | `Detector::PPT` - **.ppt**           |                                  |                                |
| `Detector::MP3` - **.mp3**   | `Detector::PPTX` - **.pptx**         |                                  |                                |
| `Detector::AAC` - **.aac**   | `Detector::ODP` - **.odp**           |                                  |                                |
| `Detector::M3U` - **.m3u**   |                                      |                                  |                                |
| `Detector::OGG` - **.ogg**   |                                      |                                  |                                |
| `Detector::WAV` - **.wav**   |                                      |                                  |                                |
