<?php
namespace PeterBenke\Pdf\Utility;

/**
 * TYPO3
 */
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Fluid utilities
 */
class FluidUtility
{

	/**
	 * Returns html-code by fluid template
	 * @param string $templatePath start from extension, e.g. '/Resources/Private/Templates/Pdf/job.html'
	 * @param array $assign
	 * @return string
	 * @author Peter Benke <info@typomotor.de>
	 */
	public static function renderFluidTemplate(string $templatePath, array $assign = []): string
	{
		$absFileName = GeneralUtility::getFileAbsFileName($templatePath);

		$view = GeneralUtility::makeInstance(StandaloneView::class);
		$view->setTemplatePathAndFilename($absFileName);
		$view->assignMultiple($assign);

		return $view->render();
	}

}