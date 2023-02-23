<?php

/*
* by KenKup
* vk.com/kenkup
* v2.1
*/

// Схема работы обхода:
// Делаем запрос на аризону, получаем js код реакта, очищаем и модифицируем его, грузим js в файл react_js.txt, выполняем js код из файла react_js.txt, берем результат выполнения у js_exec.php

define("PRETTY_TOKEN", 'N2Ej34SoSJHvfT1OmPxYHSiYKU16LAIU1o4HCAQ5ZuMf8'); // апи ключ для очистки файла
define("JS_EXEC_PATH", "https://api.mint-plantation.ru/js_exec.php"); // путь к файлу, выполняющему js код

$html = openPage('https://arizona-rp.com/'); // открываем страницу

$js = explode('var _0xfab6=', $html)[1]; // достаем код реакта
$js = explode('setTimeout', $js)[0];
$js = 'var _0xfab6='.$js.';'; // небольшой говнокод xD

$data = array('apikey' => PRETTY_TOKEN, 'js' => $js); // данные для авторизации

$curl = curl_init("https://api.dotmaui.com/client/1.0/jsbeautify/"); // запрос на сайт, который почистит код реакта в более нормальный
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 

$output = curl_exec($curl);  

curl_close($curl);

if($output == 'Api key not valid') exit('Указан НЕВЕРНЫЙ АПИ КЛЮЧ!!!');

$output = explode('document["', $output)[0]; // убираем функцию установки куки
$output = $output."document.writeln(toHex(slowAES['decrypt'](c, 2, a, b)));"; // заменяем ее на обычный вывод

file_put_contents(dirname(__FILE__) . "/react_js.txt", $output); // выгружаем код реакта с нашими модификациями в файл react_js.txt

$react = file_get_contents(JS_EXEC_PATH); // выполняем сам js код и получаем результат выполнения (токен реакта получаем)

file_put_contents(dirname(__FILE__) . "/react_js.txt", ''); // очищаем файл (защита от всевозможных инъекций)

echo $react; // выводим токен реакта

function openPage ($xnurl) { // базовый обход
	 $headers = array(
	'cache-control: max-age=0',
	'upgrade-insecure-requests: 1',
	'user-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36',
	'sec-fetch-user: ?1',
	'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
	'x-compress: null',
	'sec-fetch-site: none',
	'sec-fetch-mode: navigate',
	'accept-encoding: deflate, br',
	'accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
	);
	$ch = curl_init($xnurl);
	curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookie.txt');
	curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookie.txt');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$html = curl_exec($ch);
	curl_close($ch);
	return $html;
} 

?>