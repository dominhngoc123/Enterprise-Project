<?php

namespace common\helpers;

use backend\models\Idea;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use yii2tech\csvgrid\CsvGrid;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use ZipArchive;

class DownloadHelper
{
    public static function DownloadZipFiles()
    {
        $rootPath = realpath(Url::to('@backend') . '/web/uploads/');
        // Initialize archive object
        $zip = new \ZipArchive();
        $zipName = "ideas_" . time() . ".zip";
        $zipUrl = Url::to('@backend') . '/web/data/' . $zipName;
        $zip->open($zipUrl, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
        // Zip archive will be created only after closing object
        $zip->close();
        if (file_exists($zipUrl)) {
            var_dump("Check");
            die();
            header('Content-Description: File Transfer');
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename='.basename($zipName));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($zipUrl));
            ob_clean();
            flush();
            readfile($zipUrl);
            exit; 
            unlink($zipUrl);
        }
    }
}
