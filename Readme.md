# TYPO3 Extension ``pb_pdf`` 

## 1 Description

Pdf generation for various usages


## 2 Installation

### Installation using Composer

The recommended way to install the extension is using composer.

Run the following command within your Composer based TYPO3 project:

```
composer require peterbenke/pb-pdf
```

### Installation as extension from TYPO3 Extension Repository (TER)

Download and install the extension with the extension manager module.


## 3 Usage

#### Php file

```
<?php
namespace [YourVendor]\[YourExtension]\[...];


use PeterBenke\Pdf\Service\PdfService;
use TYPO3\CMS\Core\Utility\GeneralUtility;


class YourClass
{

  public function yourFunction()
  {
  
  
    $absoluteJobPdfPath = '/var/www/html/fileadmin/user_upload/your-pdf-file.pdf';
    $assign = [];
  
    // Create instance
  
    /** @var PdfService $pdfService */
    $pdfService = GeneralUtility::makeInstance(
        PdfService::class,
        'your_extension_key', // extension key
        '/Resources/Private/Templates/Pdf/your-template.html', // template path
        $absoluteJobPdfPath, // absolute! pdf path to pdf file
        $assign // optional assign array (fluid)
    );
    
    // Create pdf file
    
    try{
        $pdfService->create();
    }catch(Exception $e){
        echo $e->getMessage();
    }
    
  
  }

}
```

#### Template

```
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>{title}</title>
	<link rel="stylesheet" type="text/css" href="[absolute_path_to_css_file]" />
</head>
<body>
...
</body>
</html>
```