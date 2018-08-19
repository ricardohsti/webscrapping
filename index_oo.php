<?php
require "vendor/autoload.php";
require "WebScrapper.php";

class DesafioSalarioMinimo extends WebScrapper {

	public function getSalariosMinimos() {
		$this->setURL('http://www.guiatrabalhista.com.br/guia/salario_minimo.htm');

		$result = $this->filter('//div[@id="content"]/div/table/tbody/tr', function ($row) {
			$columns = $row->childNodes;
			
			if (!$columns->item(0)->hasAttribute('bgcolor')) {
				return true;
			}
		});

		$arrSalariosMinimos = [];

		foreach ($result as $row) {
			$columns = $row->childNodes;

			$arrSalariosMinimos[] = [
				'vigencia' => trim($columns->item(0)->nodeValue),
				'valor_mensal' => trim($columns->item(2)->nodeValue),
			];
		}

		return $arrSalariosMinimos;
	}

}



$desafio = new DesafioSalarioMinimo();

print_r($desafio->getSalariosMinimos());