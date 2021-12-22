<?php
namespace PeterBenke\Pdf\Service;

/**
 * PeterBenke
 */
use PeterBenke\Pdf\Utility\FluidUtility;

/**
 * TYPO3
 */
use TYPO3\CMS\Core\Core\Environment;

/**
 * Dompdf
 */
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Php
 */
use Exception;

/**
 * Generating pdf files
 */
class PdfService
{

	/**
	 * Class variables
	 * =================================================================================================================
	 */

	/**
	 * @var Dompdf
	 */
	protected $domPdf;

	/**
	 * @var string
	 */
	protected $extensionKey;

	/**
	 * @var string
	 */
	protected $templatePath;

	/**
	 * @var string
	 */
	protected $pdfPath;

	/**
	 * @var string|null
	 */
	protected $tmpDir;

	/**
	 * @var array
	 */
	protected $assign;

	/**
	 * @var bool
	 */
	protected $htmlModeOn = false;


	/**
	 * Getters and setters
	 * =================================================================================================================
	 */

	/**
	 * @return Dompdf
	 */
	protected function getDomPdf(): Dompdf
	{
		return $this->domPdf;
	}

	/**
	 *
	 */
	protected function setDomPdf(): void
	{
		$options = new Options();
		$options->setChroot(Environment::getPublicPath());
		if(!empty($this->getTmpDir())){
			$options->setTempDir($this->getTmpDir());
		}
		$this->domPdf = new Dompdf($options);
	}

	/**
	 * @return string
	 */
	public function getExtensionKey(): string
	{
		return $this->extensionKey;
	}

	/**
	 * @param string $extensionKey
	 */
	public function setExtensionKey(string $extensionKey): void
	{
		$this->extensionKey = $extensionKey;
	}

	/**
	 * @return string
	 */
	protected function getTemplatePath(): string
	{
		return $this->templatePath;
	}

	/**
	 * @param string $templatePath
	 */
	protected function setTemplatePath(string $templatePath): void
	{
		$this->templatePath = $templatePath;
	}

	/**
	 * @return string
	 */
	protected function getPdfPath(): string
	{
		return $this->pdfPath;
	}

	/**
	 * @param string $pdfPath
	 */
	protected function setPdfPath(string $pdfPath): void
	{
		$this->pdfPath = $pdfPath;
	}

	/**
	 * @return string|null
	 */
	public function getTmpDir(): ?string
	{
		return $this->tmpDir;
	}

	/**
	 * @param string|null $tmpDir
	 */
	public function setTmpDir(?string $tmpDir): void
	{
		$this->tmpDir = $tmpDir;
	}

	/**
	 * @return array
	 */
	protected function getAssign(): array
	{
		return $this->assign;
	}

	/**
	 * @param array $assign
	 */
	protected function setAssign(array $assign): void
	{
		$this->assign = $assign;
	}

	/**
	 * @return bool
	 */
	public function isHtmlModeOn(): bool
	{
		return $this->htmlModeOn;
	}

	/**
	 * @param bool $htmlModeOn
	 */
	public function setHtmlModeOn(bool $htmlModeOn): void
	{
		$this->htmlModeOn = $htmlModeOn;
	}

	/**
	 * Public functions
	 * =================================================================================================================
	 */

	/**
	 * Constructor
	 * Sets the following parameters:
	 *
	 * # template path:
	 *   path to fluid template
	 *   starting with extension key, e.g. 'EXT:extension_key/Resources/Private/Templates/Pdf/template.html'
	 *
	 * # pdf path:
	 *   absolute path to pdf file, e.g. '/var/www/html/http/fileadmin/user_upload/generated'
	 *
	 * # assign:
	 *   array with markers, which should be transferred to the fluid template
	 *
	 * # htmlModeOn:
	 *   if set to true, the html will be outputted and the script stops immediately after this
	 *
	 * @param string $extensionKey
	 * @param string $templatePath
	 * @param string $pdfPath
	 * @param string|null $tmpDir
	 * @param array $assign
	 * @param bool $htmlModeOn
	 * @author Peter Benke <info@typomotor.de>
	 */
	public function __construct(string $extensionKey, string $templatePath, string $pdfPath, ?string $tmpDir = '/tmp', array $assign = [], bool $htmlModeOn = false)
	{
		$this->setExtensionKey($extensionKey);
		$this->setTemplatePath($templatePath);
		$this->setPdfPath($pdfPath);
		$this->setTmpDir($tmpDir);
		$this->setAssign($assign);
		$this->setHtmlModeOn($htmlModeOn);
		$this->setDomPdf();
	}

	/**
	 * Creates the pdf file on filesystem
	 * @throws Exception
	 * @author Peter Benke <info@typomotor.de>
	 */
	public function create()
	{

		$domPdf = $this->getDomPdf();

		$domPdf->setPaper('A4');
		$html = FluidUtility::renderFluidTemplate($this->getExtensionKey(), $this->getTemplatePath(), $this->getAssign());

		if($this->isHtmlModeOn()){
			echo $html;
			die();
		}

		$domPdf->loadHtml($html, 'UTF-8');
		$domPdf->render();

		if (!file_put_contents($this->getPdfPath(), $domPdf->output())) {
			throw new Exception('Pdf file could not be generated.');
		}
	}

}