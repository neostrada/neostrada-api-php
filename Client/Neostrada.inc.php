<?php
/**
 * Copyright (c) 2012, Avot Media BV
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR AND CONTRIBUTORS ``AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH
 * DAMAGE.
 *
 * @license     Berkeley Software Distribution License (BSD-License 2) http://www.opensource.org/licenses/bsd-license.php
 * @author      Avot Media BV <api@neostrada.nl>
 * @copyright   Avot Media BV
 * @link        http://www.avot.nl / http://www.neostrada.nl
 */
final class Neostrada {
	/**
	 * Defines the Client version
	 */
	const CLIENT_VERSION = '1.0.0';
	/**
	 * Defines the API endpoint
	 */
	const API_ENDPOINT = 'https://api.neostrada.nl/';
	/**
	 * Contains the Neostrada class instance (singleton)
	 */
	private static $Instance = NULL;
	/**
	 * Contains the neostrada api key
	 */
	private $APIKey = '';
	/**
	 * Contains the neostrada api secret
	 */
	private $APISecret = '';
	/**
	 * Contains the current url
	 */
	private $URL = '';
	/**
	 * Contains the cURL session
	 */
	private $cURL = FALSE;
	/**
	 * Contains the cURL request result
	 */
	private $Data = FALSE;
	/**
	 * Returns the Neostrada class instance and creates it if needed
	 */
	public static function GetInstance()
	{
		if (self::$Instance === NULL) self::$Instance = new Neostrada;
		return self::$Instance;
	}
	/**
	 * Sets the neostrada api key
	 */
	public function SetAPIKey($APIKey)
	{
		$this->APIKey = $APIKey;
	}
	/**
	 * Sets the neostrada api secret
	 */
	public function SetAPISecret($APISecret)
	{
		$this->APISecret = $APISecret;
	}
	/**
	 * Opens a new cURL session for the requested action
	 */
	public function prepare($Action, $Parameters = array())
	{
		$RV = FALSE;
		$this->close();
		if (($this->cURL = curl_init()) !== FALSE) {
			curl_setopt($this->cURL, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($this->cURL, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($this->cURL, CURLOPT_URL, self::API_ENDPOINT.'?api_key='.$this->APIKey.'&action='.$Action.'&'.http_build_query($Parameters).'&api_sig='.$this->_api_signature($Action, $Parameters));
			curl_setopt($this->cURL, CURLOPT_HEADER, 0);
			curl_setopt($this->cURL, CURLOPT_RETURNTRANSFER, 1);
			$RV = TRUE;
		}
		return $RV;
	}
	/**
	 * Executes the cURL session and fetches the result
	 */
	public function execute()
	{
		$RV = FALSE;
		if ($this->cURL !== FALSE && ($this->Data = curl_exec($this->cURL)) !== FALSE) $RV = TRUE;
		$this->close();
		return $RV;
	}
	/**
	 * Returns the fetched result from the cURL session
	 * Note: only works after Execute() is called!
	 */
	public function fetch()
	{
		$RV = FALSE;
		if ($this->Data !== FALSE && ($XML = @simplexml_load_string($this->Data)) !== FALSE) {
			$RV = array();
			foreach ($XML->attributes() AS $AV) $RV[strtolower($AV->getName())] = trim((string)$AV);
			foreach ($XML->children() AS $CV) {
				if (count($CV->children()) > 0) {
					foreach ($CV->children() AS $CCV) $RV[strtolower($CV->getName())][] = trim((string)$CCV);
				} else {
					$RV[strtolower($CV->getName())] = trim((string)$CV);
				}
			}
		}
		return $RV;
	}
	/**
	 * Closes the current cURL session and cleans up the class variables
	 */
	public function close()
	{
		if ($this->cURL !== FALSE) curl_close($this->cURL);
		$this->cURL = FALSE;
	}
	/**
	 * Creates a API signature of the given action and parameters
	 */
	private function _api_signature($Action, array $Parameters = array())
	{
		$APISig = $this->APISecret.$this->APIKey.'action'.$Action;
		foreach ($Parameters AS $Key => $Value) $APISig.= $Key.$Value;
		return md5($APISig);
	}
}
?>