<?php
namespace PeterBenke\Pdf\Utility;

/**
 * TYPO3
 */
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Php
 */
use Exception;

/**
 * Fluid utilities
 */
class FluidUtility
{

	/**
	 * Returns html-code by fluid template
	 * @param string $extensionKey extension key, from where the pdf should be generated
	 * @param string $templatePath start from extension, e.g. '/Resources/Private/Templates/Pdf/job.html'
	 * @param array $assign
	 * @return string
	 * @throws Exception
	 * @author Peter Benke <info@typomotor.de>
	 */
	public static function renderFluidTemplate(string $extensionKey, string $templatePath, array $assign = []): string
	{

        $extensionName = GeneralUtility::underscoredToUpperCamelCase($extensionKey);
        $templatePath = "/" . ltrim(  $templatePath , "/")  ;

        $absFileName = GeneralUtility::getFileAbsFileName('EXT:' . $extensionKey . $templatePath);

        $template = basename($absFileName , ".html" ) ;
        $templateFolder = dirname($templatePath  ) ;

		$view = GeneralUtility::makeInstance(StandaloneView::class);
		$view->setTemplate($template);
        $view->setTemplateRootPaths([0 => 'EXT:' . $extensionKey . $templateFolder ] );

        $view->setTemplatePathAndFilename($absFileName);
		$view->assignMultiple($assign);
		// To get the correct locallang files
		$view->getRequest()->setControllerExtensionName($extensionName);
		return $view->render();
	}

}