# FileTypeDetector

[![Composer package](http://xn--e1adiijbgl.xn--p1acf/badge/wapmorgan/file-type-detector)](https://packagist.org/packages/wapmorgan/file-type-detector)
[![Latest Stable Version](https://poser.pugx.org/wapmorgan/file-type-detector/v/stable)](https://packagist.org/packages/wapmorgan/file-type-detector)
[![Total Downloads](https://poser.pugx.org/wapmorgan/file-type-detector/downloads)](https://packagist.org/packages/wapmorgan/file-type-detector)
[![Latest Unstable Version](https://poser.pugx.org/wapmorgan/file-type-detector/v/unstable)](https://packagist.org/packages/wapmorgan/file-type-detector)
[![License](https://poser.pugx.org/wapmorgan/file-type-detector/license)](https://packagist.org/packages/wapmorgan/file-type-detector)


### How to detect by file name
```php
$type = wapmorgan\FileTypeDetector\Detector::detectByFilename(...filename...);
```
`$type` will contain file type as an array like this:
```
[0] => Detector::AUDIO,
[1] => Detector::MP3
```
In case of failure it will contain `false`.

### How to detect by file content
```php
$type = wapmorgan\FileTypeDetector\Detector::detectByContent(...filename...);
// or
$type = wapmorgan\FileTypeDetector\Detector::detectByContent(...stream...);
```
`$type` can have the same values as described above.

## List of types
* AUDIO
* VIDEO
* IMAGE
* ARCHIVE
* DATABASE
* FONT
* APPLICATION
* PRESENTATION
* SPREADSHEET

**Detector::AUDIO**
* Detector::FLAC
* Detector::WMA
* Detector::AMR
* Detector::MP3
* Detector::AAC
* Detector::M3U

**Detector::VIDEO**
* Detector::THREE_GP
* Detector::AVI
* Detector::FLV
* Detector::M4V
* Detector::MKV
* Detector::MOV
* Detector::MPEG
* Detector::VOB

**Detector::IMAGE**
* Detector::JPEG
* Detector::BMP
* Detector::GIF
* Detector::PNG
* Detector::TIFF
* Detector::PSD

**Detector::ARCHIVE**
* Detector::BZIP2
* Detector::GZIP
* Detector::LZMA
* Detector::XZ
* Detector::SEVEN_ZIP
* Detector::CAB
* Detector::JAR
* Detector::RAR
* Detector::TAR
* Detector::ZIP

**Detector::DATABASE**
* Detector::MDB

**Detector::DOCUMENT**
* Detector::DOC
* Detector::DOCX
* Detector::HTML
* Detector::ODT
* Detector::PDF
* Detector::RTF
* Detector::TXT
* Detector::XML

**Detector::FONT**
* Detector::OTF
* Detector::TTF

**Detector::APPLICATION**
* Detector::APK
* Detector::COM
* Detector::EXE

**Detector::PRESENTATION**
* Detector::PPT
* Detector::PPTX
* Detector::ODP

**Detector::SPREADSHEET**
* Detector::ODS
* Detector::XLS
* Detector::XLSX
