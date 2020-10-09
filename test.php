<?php
//PHP 7.2.x
require_once 'Briskly/Exchanger/XlsExchange.php';
require_once 'Briskly/Exchanger/FileFactory.php';
require_once 'Briskly/Exchanger/Converter.php';
require_once 'vendor/autoload.php';

(new \Briskly\Exchanger\XlsExchange())
    ->setInputFile('orders.json')
    ->setOutputFile('items.xlsx')
//    ->setFtpHost('ftp.cs.brown.edu')
//    ->setFtpDir('incoming/')
    ->export();