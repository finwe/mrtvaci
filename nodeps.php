<?php

require_once __DIR__ . '/vendor/autoload.php';

$image = imagecreatefromjpeg(__DIR__ . '/andrej.jpg');

$today = new DateTimeImmutable();
$todayJson = $today->format('Ymd') . '.json';

if (!file_exists($todayJson)) {
	file_put_contents($todayJson, file_get_contents('https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/latest/owid-covid-latest.json'));
}

$data = json_decode(file_get_contents($todayJson), true, 512, JSON_THROW_ON_ERROR);

$color = imagecolorallocate($image, 35, 39, 94);

imagettftext($image, 10, 0, 529, 212, $color, __DIR__ . '/arial.ttf', (new DateTimeImmutable())->format('j. n. Y'));
imagettftext($image, 18, 0, 266, 111, $color, __DIR__ . '/arial.ttf', number_format($data['CZE']['total_deaths'], 0, ',', ' '));

header('Content-Type: image/jpeg');
imagejpeg($image);


