<?php

require './vendor/autoload.php';

use YouTube\YouTubeDownloader;
use YouTube\Exception\YouTubeException;

$youtube = new YouTubeDownloader();

try {
    $downloadOptions = $youtube->getDownloadLinks("https://www.youtube.com/watch?v=JGLcDHbZqAE");
    if ($videos = $downloadOptions->getCombinedFormats()) {
        $video = end($videos);
        var_dump($video);
    } else {
        echo 'No links found';
    }

} catch (YouTubeException $e) {
    echo 'Something went wrong: ' . $e->getMessage();
}