<?php
use GuzzleHttp\Client as GuzzleClient;

class WebScrapper {
	private $_clientHttp;
	private $_url;

	public function __construct($url = NULL) {
		if ($url) {
			$this->setURL($url);
		}

	}

	public function getClientHttp() {
		if (!$this->_clientHttp instanceof GuzzleHttp\Client) {
			$this->initClientHttp();
		}

		return $this->_clientHttp;
	}

	public function initClientHttp() {
		$this->_clientHttp = new GuzzleClient();
	}

	public function getURL() {
		if (!$this->_url || strlen($this->_url) == 0) {
			throw new Exception("URL is not defined", 1);			
		}

		return $this->_url;
	}

	public function setURL($url) {
		$this->_url = $url;
	}

	public function filter($query, $handler = NULL) {
		$responseText = $this->request('GET', $this->getURL());
		$responseObject = $this->parseAsObject($responseText);

		$rows = $responseObject->query($query);

		if ($handler) {
			$handledRows = [];
			
			foreach($rows as $row) {
				if ($handler($row)) {
					$handledRows[] = $row;
				}
			}

			$rows = $handledRows;
		}

		return $rows;
	}

	public function request($method, $url) {
		$clientHttp = $this->getClientHttp();

		try {
			$response = $clientHttp->request($method, $url);

			return ($response->getStatusCode() == 200) ? $response->getBody() : NULL;
		} catch (\Exception $e) {
			return $e;
		}
	}

	public function parseAsObject($htmlContent) {
		$dom = new DOMDocument;
		libxml_use_internal_errors(true);
		$dom->loadHTML($htmlContent);
		libxml_clear_errors();

		return new DOMXPath($dom);
	}
}