<?php
require "vendor/autoload.php";

use GuzzleHttp\Client;

$client = new Client();

$url = 'http://www.guiatrabalhista.com.br/guia/salario_minimo.htm';


$response = $client->request('GET', $url);

if ($response->getStatusCode() == 200) {
	$bodyContent = $response->getBody();


	$dom = new DOMDocument;
	$dom->loadHTML($bodyContent);

	$xpath = new DOMXPath($dom);

	// We starts from the root element
	$query = '//div[@id="content"]/div/table/tbody/tr';

	$rows = $xpath->query($query);

	$arrFinal = [];

	foreach($rows as $row) {
		$columns = $row->getElementsByTagName('td');
		if (!$columns->item(0)->hasAttribute('bgcolor')) {
			$arrFinal[] = [
				'vigencia' => trim($columns->item(0)->nodeValue),
				'valor_mensal' => trim($columns->item(1)->nodeValue),
			];
		}
	}

	print_r($arrFinal);
} else {
	echo "Desculpe, a requisição retornou erro " . $response->getStatusCode(). ".";
}