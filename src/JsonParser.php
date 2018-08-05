<?php

/**
 * Slim 3 JSON Parser - Parsing JSON response for REST API with CORS management
 * 
 * @package Slim
 * @author Muhammad Alfasih <x@alal.io>
 * @license MIT
 *
 */

namespace Malfasih\Slim;

use Psr\Http\Message\ResponseInterface;

class JsonParser {

	/**
	 * Contains response data
	 * @var object
	 */
	private $buffer;


	/**
	 * @var int
	 */
	private $http_status_code = 200;


	/**
	 * A message of what the response describe.
	 * @var string
	 */
	private $message = null;


	/**
	 * Content-type header must be changed to make the JSON readable by browsers.
	 * @var string
	 */
	private $contentType = 'application/json';


	/**
	 * Example 1: JSON_PRETTY_PRINT
	 * Example 2: JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT
	 * http://php.net/manual/en/function.json-encode.php
	 * @var string
	 */
	private $options = false;


	/**
	 * Enable or Disable CORS Header
	 * @var boolean
	 */
	private $cors_status = true;

	/**
	 * Combined CORS options for final settings.
	 * @var array
	 */
	private $cors_settings = array();


	/**
	 * Whitelisted domain that can only access the endpoint, "*" for wildcard.
	 * @var string
	 */
	private $cors_domain = "*";


	/**
	 * Endpoint only accept selected method(s).
	 * @var string
	 */
	private $cors_methods = "X-Requested-With, Content-Type, Accept, Origin, Authorization";


	/**
	 * Endpoint only accept selected method(s).
	 * @var string
	 */
	private $cors_headers = "GET, POST, PUT, DELETE, PATCH, OPTIONS";


	/**
	 * Allow user to change CORS settings.
	 * @var string
	 */
	public function setConfig($options = false, $contentType = '', $cors_status = true) {
		if ($contentType !== '') {
			$this->contentType = $contentType;
		}

		if ($options !== false) {
			$this->options = $options;
		}

		$this->cors_status = (bool) $cors_status;
	}


	/**
	 * Allow user to change CORS settings.
	 * @var string
	 */
	public function setCORS($domain = '', $methods = '', $headers = '') {
		if ($domain !== '') {
			$this->cors_domain = $domain;
		}
		if ($methods !== '') {
			$this->cors_methods = $methods;
		}
		if ($headers !== '') {
			$this->cors_headers = $headers;
		}
	}


	/**
	 * Return the JSON parsed of given params
	 * @return string 
	 */
	public function print(ResponseInterface $response, $status = false, $message = array()) {
		$arrayBody = ['status' => $status, 'text' => $message];

		$buffer = $response->withHeader('Content-Type', $this->contentType);
		if ($this->cors_status === true) {
			$buffer = $buffer->withHeader('Access-Control-Allow-Origin', $this->cors_domain)
				   			 ->withHeader('Access-Control-Allow-Headers', $this->cors_headers)
				   			 ->withHeader('Access-Control-Allow-Methods', $this->cors_methods);
		}

		if ($this->options !== false) {
			$buffer->write(json_encode($arrayBody, $this->options));
		} else {
			$buffer->write(json_encode($arrayBody));
		}
		return $buffer;
	}

}

?>
