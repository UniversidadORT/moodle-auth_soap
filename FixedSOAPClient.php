<?php

/**
 * @author jonasraoni 
 * Fix from jonasraoni at gmail dot com found at https://bugs.php.net/bug.php?id=33366
*/

class FixedSOAPClient extends SoapClient {
	private $method;
	private $argumentCount;

	public function call($function, $arguments, $options){
		$this->argumentCount = count($arguments);
		/*
		Adding a bogus parameter to the beginning, since the SoapClient is "eating" the first argument.
		*/
		array_unshift($arguments, 0);
		return parent::__call($this->method = $function, $arguments);
	}
	public function __doRequest($request, $location, $action, $version, $oneWay = 0){
		$xml = new DOMDocument('1.0', 'utf-8');
		$xml->loadXML($request);
		$d = $xml->documentElement;
		/*
		Placing the "lost" arguments inside the function node, their right place.
		*/
		for($o = $d->getElementsByTagName($this->method)->item(0); $o->nextSibling; $o->appendChild($o->nextSibling));
		$xml = $xml->saveXML();
		/*
		Removing boundary from the XML result, this must be part of a standard as the calls works fine on other tools, the SoapClient should be able to handle it.
		*/
		$s = preg_replace('/--.*?--$/', '', preg_replace('/^(?:.|\n|\r)*?<soap:/', '<soap:', parent::__doRequest($xml, $location, $action, $version, $oneWay)));
		return $s;
	}
}

?>

