<?php

require './vendor/autoload.php';

use YouTube\YouTubeDownloader;
use YouTube\Exception\YouTubeException;

$youtube = new YouTubeDownloader();

try {
    $downloadOptions = $youtube->getDownloadLinks("https://www.youtube.com/watch?v=JGLcDHbZqAE");
    var_dump($downloadOptions);
    if ($downloadOptions->getAllFormats()) {
        echo $downloadOptions->getFirstCombinedFormat()->url;
    } else {
        echo 'No links found';
    }

} catch (YouTubeException $e) {
    echo 'Something went wrong: ' . $e->getMessage();
}