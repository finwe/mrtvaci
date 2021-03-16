<?php

require_once __DIR__ . '/vendor/autoload.php';

$image = \Nette\Utils\Image::fromFile(__DIR__ . '/andrej.jpg');

$today = new DateTimeImmutable();
$todayJson = $today->format('Ymd') . '.json';

if (!file_exists($todayJson)) {
	file_put_contents($todayJson, file_get_contents('https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/latest/owid-covid-latest.json'));
}

$data = \Nette\Utils\Json::decode(file_get_contents($todayJson), \Nette\Utils\Json::FORCE_ARRAY);

$color = $image->colorAllocate(35, 39, 94);

$image->ttfText(10, 0, 529, 212, $color, __DIR__ . '/arial.ttf', (new DateTimeImmutable())->format('j. n. Y'));
$image->ttfText(18, 0, 266, 111, $color, __DIR__ . '/arial.ttf', number_format($data['CZE']['total_deaths'], 0, ',', ' '));

$image->send();


