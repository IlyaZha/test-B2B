<?php
/*
	Имеется строка:
	https://www.somehost.com/test/index.html?param1=4&param2=3&param3=2&param4=1&param5=3
	Напишите функцию, которая:
	удалит параметры со значением “3”;
	отсортирует параметры по значению;
	добавит параметр url со значением из переданной ссылки без параметров (в примере: /test/index.html);
	сформирует и вернёт валидный URL на корень указанного в ссылке хоста.
	В указанном примере функцией должно быть возвращено:
	https://www.somehost.com/?param4=1&param3=2&param1=4&url=%2Ftest%2Findex.html
*/

function processUrl($url, $filteredValue = '3') {
	$parts = parse_url($url);

	parse_str($parts['query'], $params);
	$params = array_filter($params, function ($item) use ($filteredValue) {
		return $item !== $filteredValue;
	});
	asort($params);

	$params['url'] = $parts['path'];

	$host = $parts['scheme'] . '://' . $parts['host'];
	$result = $host . '/?' . http_build_query($params);

	return $result;
}