<?php

namespace App;

use YouTube\YouTubeDownloader;
use YouTube\Exception\YouTubeException;

class Main
{
	public function __construct()
	{
		$url = Input::get("u") ?? Input::get("url") ?? Input::prompt("Youtube URL: ");
		$urlInfo = parse_url($url);
		$ytDomains = ["youtube.com", "youtu.be"];
		$dm = false;
		foreach ($ytDomains as $domain)
		{
			if (strpos($urlInfo['host'], $domain) !== false)
			{
				$dm = true;
			}
		}
		parse_str($urlInfo['query'], $searchParams);
		$id = $searchParams['v'] ?? null;
		if (!$id || !$dm) {
			throw new \Error("Invalid youtube video URL", 400);
		}

		$youtube = new YouTubeDownloader();

		try {
		    $downloadOptions = $youtube->getDownloadLinks($url);
		    if ($videos = $downloadOptions->getCombinedFormats()) {
		        $video = end($videos);
		    } else {
		        echo 'No links found';
		    }
		} catch (YouTubeException $e) {
		    echo 'Something went wrong: ' . $e->getMessage();
		}

		Output::write("Video link: ");
		Output::writeln($video->url, "CYAN");
	}
}