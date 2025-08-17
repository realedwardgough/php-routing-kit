<?php

// Tempory file until I can sort the rework for the composer.json file to handle these correctly
$directory = __DIR__;
$iterator = new \DirectoryIterator($directory);

// Load all files within the Routes directory which aren't the current file.
foreach ($iterator as $fileInfo) {
   if ($fileInfo->isFile() && 
      $fileInfo->getExtension() === 'php' && 
      $fileInfo->getRealPath() !== __FILE__) {
      require_once $fileInfo->getRealPath();
   }
}