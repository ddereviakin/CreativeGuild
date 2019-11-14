
<?php
/**
 * 
 * @author Stephen J.
 *
 */
class Translate{
	
	# private variables
	private $client;
	private $params;
	
	/**
	 * 
	 * Initializes the traslation microsopts translation api using SoapClient
	 */
	public function Translate(){
		$this->client = new SoapClient("http://api.microsofttranslator.com/V2/SOAP.svc");
		
		$this->params = array();
		$this->params['appId'] = 'EB9252F60397E993D55440BE38379FAC7721ADB4';
	}
	
	/**
	 * 
	 * Translates the given text to given language
	 * @param text string
	 * @param from string	(De - German, It - Italian, Ja - Japanese, Ko - Korean, Pl - Polish, Pt - Portuguese, Ru - Russian, Es - Spanish)
	 * @param to string		(Ar - Arabic, zh-CHS - Simplified Chinese, zh-CHT - Traditional Chinese, Nl - Dutch, En - English, Fr - French)
	 * @param type string
	 * @return translateresult string
	 */
	public function translateHTML($text, $to, $from=false, $type='text/html'){
		
		$this->params['contentType']	= $type;
		$this->params['text']			= $text;
		if($from) $this->params['from']	= $from;
		$this->params['to']				= $to;
		
		$result = $this->client->Translate($this->params);
		
		//if(!$result) return false;
		var_dump($result);
		return $result->TranslateResult;
	}
}


/*
 * ------------------------------------------------------------ Tests ------------------------------------------------------------
 */
/*
$translate = new Translate();
$translatedText = $translate->translateHTML('Hello’', 'en');
var_dump($translatedText);
if($translatedText=='') echo "false";

echo $translatedText."<br/><br/>";
*/


?>
