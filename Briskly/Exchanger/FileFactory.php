<?php
/**
 * File Factory
 *
 * @author mikxail.karev@gmail.com
 */
declare(strict_types=1);

namespace Briskly\Exchanger;

use altayalp\FtpClient\FileFactory as FTPFileFactory;
use altayalp\FtpClient\Servers\FtpServer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use stdClass;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use altayalp\FtpClient\Exceptions\ExtensionMissingException;

/**
 * Class FileFactory
 */
class FileFactory
{
    /**
     * Tmp folder name
     */
    const TMP_FOLDER = 'tmp';

    /**
     * Get data from json file
     *
     * @param string $fileName
     *
     * @return stdClass
     */
    public function getData(string $fileName): ?stdClass
    {
        $result = null;
        if (file_exists($this->getPathToFile($fileName))) {
            $json = file_get_contents($this->getPathToFile($fileName));
            $result = json_decode($json);
        }

        return $result;
    }

    /**
     * Save data
     *
     * @param $spreadsheet
     * @param $fileName
     * @param $ftpHost
     * @param $ftpLogin
     * @param $ftpPassword
     * @param $ftpDir
     *
     * @throws Exception
     * @throws ExtensionMissingException
     */
    public function saveData(
        Spreadsheet $spreadsheet,
        string $fileName,
        ?string $ftpHost,
        string $ftpLogin,
        string $ftpPassword,
        string $ftpDir
    ): void {
        $writer = new Xlsx($spreadsheet);
        $writer->save($this->getPathToFile($fileName));

        if (!is_null($ftpHost)) {
            $server = new FtpServer($ftpHost);
            $server->login($ftpLogin, $ftpPassword);
            $server->turnPassive();
            $file = FTPFileFactory::build($server);
            $file->upload(
                $this->getPathToFile($fileName),
                $ftpDir . $fileName
            );
        }
    }

    /**
     * Get path to file
     *
     * @param string $fileName
     *
     * @return string
     */
    protected function getPathToFile(string $fileName): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . self::TMP_FOLDER . DIRECTORY_SEPARATOR . $fileName;
    }
}
