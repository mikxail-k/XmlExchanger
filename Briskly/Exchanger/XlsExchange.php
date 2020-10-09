<?php
/**
 * JSON to XLSX exchanger
 *
 * @author mikxail.karev@gmail.com
 */
declare(strict_types=1);

namespace Briskly\Exchanger;

/**
 * Class XlsExchange
 */
class XlsExchange
{
    /**
     * Path to input file
     *
     * @var string
     */
    protected $pathToInputJsonFile;

    /**
     * Path to output file
     *
     * @var string
     */
    protected $pathToOutputXlsxFile;

    /**
     * FTP host
     *
     * @var string|null
     */
    protected $ftpHost = null;

    /**
     * FTP login
     *
     * @var string
     */
    protected $ftpLogin = 'anonymous';

    /**
     * FTP password
     *
     * @var string
     */
    protected $ftpPassword = '';

    /**
     * FTP dir
     *
     * @var string
     */
    protected $ftpDir = '';

    /**
     * Set input file
     *
     * @param string $inputFile
     *
     * @return $this
     */
    public function setInputFile(string $inputFile): self
    {
        $this->pathToInputJsonFile = $inputFile;

        return $this;
    }

    /**
     * Get input file
     *
     * @return string
     */
    protected function getInputFile(): string
    {
        return $this->pathToInputJsonFile;
    }

    /**
     * Set output file
     *
     * @param string $outputFile
     *
     * @return $this
     */
    public function setOutputFile(string $outputFile): self
    {
        $this->pathToOutputXlsxFile = $outputFile;

        return $this;
    }

    /**
     * Get output file
     *
     * @return string
     */
    protected function getOutputFile(): string
    {
        return $this->pathToOutputXlsxFile;
    }

    /**
     * Set FTP host
     *
     * @param string $ftpHost
     *
     * @return $this
     */
    public function setFtpHost(string $ftpHost): self
    {
        $this->ftpHost = $ftpHost;

        return $this;
    }

    /**
     * Get FTP host
     *
     * @return string|null
     */
    protected function getFtpHost()
    {
        return $this->ftpHost;
    }

    /**
     * Set FTP login
     *
     * @param string $ftpLogin
     *
     * @return $this
     */
    public function setFtpLogin(string $ftpLogin): self
    {
        $this->ftpLogin = $ftpLogin;

        return $this;
    }

    /**
     * Get FTP login
     *
     * @return string
     */
    protected function getFtpLogin()
    {
        return $this->ftpLogin;
    }

    /**
     * Set FTP password
     *
     * @param string $ftpPassword
     *
     * @return $this
     */
    public function setFtpPassword(string $ftpPassword): self
    {
        $this->ftpPassword = $ftpPassword;

        return $this;
    }

    /**
     * Get FTP password
     *
     * @return string
     */
    protected function getFtpPassword()
    {
        return $this->ftpPassword;
    }


    /**
     * Set FTP dir
     *
     * @param string $ftpDir
     *
     * @return $this
     */
    public function setFtpDir(string $ftpDir): self
    {
        $this->ftpDir = $ftpDir;

        return $this;
    }

    /**
     * Get FTP dir
     *
     * @return string
     */
    protected function getFtpDir()
    {
        return $this->ftpDir;
    }

    /**
     * Export
     */
    public function export(): void
    {
        $fileFactory = new FileFactory();
        $converter = new Converter();
        try {
            $data = $fileFactory->getData($this->getInputFile());
            if ($data) {
                $spreadsheet = $converter->convert($data);
                $fileFactory->saveData(
                    $spreadsheet,
                    $this->getOutputFile(),
                    $this->getFtpHost(),
                    $this->getFtpLogin(),
                    $this->getFtpPassword(),
                    $this->getFtpDir()
                );
            } else {
                echo 'Input file not found.';
            }
        } catch (\Exception $e) {
            //logging
            echo 'Something went wrong.';
        }
    }
}
