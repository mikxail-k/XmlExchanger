<?php
/**
 * Converter
 *
 * @author mikxail.karev@gmail.com
 */
declare(strict_types=1);

namespace Briskly\Exchanger;

use Ced\Validator\Barcode;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use stdClass;

/**
 * Class Converter
 */
class Converter
{
    /**
     * Convert to xlsx
     *
     * @param $data
     *
     * @return Spreadsheet
     */
    public function convert(stdClass $data): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $this->formTable($sheet);
        $this->fillTable($data, $sheet);

        return $spreadsheet;
    }

    /**
     * Form table
     *
     * @param Worksheet $sheet
     */
    protected function formTable(Worksheet $sheet): void
    {
        $sheet->getColumnDimension('B')->setWidth(16);
        $sheet->getColumnDimension('C')->setWidth(48);
        $sheet
            ->setCellValue('A1', 'Id')
            ->setCellValue('B1', 'ШК')
            ->setCellValue('C1', 'Название')
            ->setCellValue('D1', 'Кол-во')
            ->setCellValue('E1', 'Сумма');
    }

    /**
     * Fill table
     *
     * @param stdClass $data
     * @param Worksheet $sheet
     */
    protected function fillTable(stdClass $data, Worksheet $sheet): void
    {
        $barcodeValidator = new Barcode();
        if ($data->items) {
            foreach ($data->items as $key => $element) {
                $number = $key + 2;
                $sheet
                    ->setCellValue('A' . $number, $element->item->id);
                $barcodeValidator->setBarcode($element->item->barcode);
                if ($barcodeValidator->isValid()) {
                    $sheet->setCellValue('B' . $number, $element->item->barcode);
                } else {
                    $sheet->setCellValue('B' . $number, 'Invalid Barcode');
                }
                $sheet
                    ->setCellValue('C' . $number, $element->item->name)
                    ->setCellValue('D' . $number, $element->quantity)
                    ->setCellValue('E' . $number, $element->price);
            }
        }
    }
}
