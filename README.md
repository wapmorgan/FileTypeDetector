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
| `Detector::BMP` - **.bmp**   | `Detector::MDB` - **.mdb**           | `Detector::OTF` - **.otf**       | `Detector::_7ZIP` - **.7z**    |
| `Detector::GIF` - **.gif**   | `Detector::ODB` - **.odb**           | `Detector::TTF` - **.ttf**       | `Detector::ARJ` - **.arj**     |
| `Detector::JPEG` - **.jpeg** |                                      |                                  | `Detector::BZIP2` - **.bzip2** |
| `Detector::PNG` - **.png**   | **Spreadsheets**                     | **Executables and applications** | `Detector::CAB` - **.cab**     |
| `Detector::PSD` - **.psd**   | `Detector::CSV` - **.csv**           | `Detector::APK` - **.apk**       | `Detector::GZIP` - **.gzip**   |
| `Detector::TIFF` - **.tiff** | `Detector::ODS` - **.ods**           | `Detector::COM` - **.com**       | `Detector::ISO` - **.iso**     |
|                              | `Detector::TSV` - **.tsv**           | `Detector::EXE` - **.exe**       | `Detector::JAR` - **.jar**     |
| **Videos**                   | `Detector::XLS` - **.xls**           |                                  | `Detector::LZMA2` - **.lzma2** |
| `Detector::_3GP` - **.3gp**  | `Detector::XLSX` - **.xlsx**         |                                  | `Detector::RAR` - **.rar**     |
| `Detector::ASF` - **.asf**   |                                      |                                  | `Detector::TAR` - **.tar**     |
| `Detector::AVI` - **.avi**   | **Text and documents**               |                                  | `Detector::ZIP` - **.zip**     |
| `Detector::FLV` - **.flv**   | `Detector::DOC` - **.doc**           |                                  |                                |
| `Detector::M4V` - **.m4v**   | `Detector::DOCX` - **.docx**         |                                  | **Interned feeds**             |
| `Detector::MKV` - **.mkv**   | `Detector::HTML` - **.html**         |                                  | `Detector::ATOM` - **.atom**   |
| `Detector::MOV` - **.mov**   | `Detector::ODT` - **.odt**           |                                  | `Detector::RSS` - **.rss**     |
| `Detector::MPEG` - **.mpeg** | `Detector::PDF` - **.pdf**           |                                  |                                |
| `Detector::MP4` - **.mp4**   | `Detector::RTF` - **.rtf**           |                                  |                                |
| `Detector::SWF` - **.swf**   | `Detector::TXT` - **.txt**           |                                  |                                |
| `Detector::VOB` - **.vob**   | `Detector::MARKDOWN` - **.markdown** |                                  |                                |
| `Detector::WEBM` - **.webm** | `Detector::JSON` - **.json**         |                                  |                                |
| `Detector::WMV` - **.wmv**   | `Detector::XML` - **.xml**           |                                  |                                |
|                              | `Detector::YAML` - **.yaml**         |                                  |                                |
| **Audios**                   |                                      |                                  |                                |
| `Detector::AAC` - **.aac**   | **Presentations**                    |                                  |                                |
| `Detector::AMR` - **.amr**   | `Detector::PPT` - **.ppt**           |                                  |                                |
| `Detector::FLAC` - **.flac** | `Detector::PPTX` - **.pptx**         |                                  |                                |
| `Detector::M3U` - **.m3u**   | `Detector::ODP` - **.odp**           |                                  |                                |
| `Detector::MIDI` - **.midi** |                                      |                                  |                                |
| `Detector::MP3` - **.mp3**   |                                      |                                  |                                |
| `Detector::OGG` - **.ogg**   |                                      |                                  |                                |
| `Detector::WAV` - **.wav**   |                                      |                                  |                                |
| `Detector::WMA` - **.wma**   |                                      |                                  |                                |
