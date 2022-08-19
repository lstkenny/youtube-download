<?php

namespace src\php;

class Main
{
	public function __construct()
	{
		$url = Input::get("u") ?? Input::get("url") ?? Input::prompt("Youtube URL: ");
		$url = parse_url($url);
		$ytDomains = ["youtube.com", "youtu.be"];
		$dm = false;
		foreach ($ytDomains as $domain)
		{
			if (strpos($url['host'], $domain) !== false)
			{
				$dm = true;
			}
		}
		parse_str($url['query'], $searchParams);
		$id = $searchParams['v'] ?? null;
		if (!$id || !$dm) {
			throw new \Error("Invalid youtube video URL", 400);
		}
		Output::write("Video id: ");
		Output::writeln($id, "CYAN");

	}
}