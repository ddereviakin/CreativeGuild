<?php
/**
 * 
 * @author stephen
 *
 */
class Encryption{
	
	/**
	 * Encrypts the data given with the key
	 * @param data string
	 * @param key string
	 * @return encryptedtext string
	 */
	public function encryptCC($data,$key) {
		
		# Opens the module of the algorithm and the mode to be used
		$algorithm = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '','cfb', '');
		
		$iv_size = mcrypt_enc_get_iv_size($algorithm);				// Returns the size of the IV of the opened algorithm
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);				// Create an initialization vector (IV) from a random source
		
		$key = md5($key);											// Calculate the md5 hash of a string
		$key = substr($key, 0, mcrypt_enc_get_key_size($algorithm));// Returns the maximum supported keysize of the opened mode
		
		if (mcrypt_generic_init($algorithm, $key, $iv) === 0){ 		// This function initializes all buffers needed for encryption

			$encryptedtext = mcrypt_generic($algorithm, $data);		// This function encrypts data
			mcrypt_generic_deinit($algorithm);						// This function deinitializes an encryption module
			mcrypt_module_close($algorithm);						// Close the mcrypt module
			$encryptedtext = $iv.$encryptedtext;
			return base64_encode($encryptedtext);					// Encodes data with MIME base64
			//return strtr(base64_encode(addslashes(gzcompress(serialize($encryptedtext),9))), '+=', '-_');
		}
		
		return $data;
	}
	
	/**
	 * Decrypts the data given with the key
	 * @param data string
	 * @param key string
	 * @return decryptedtext string
	 */
	public function decryptCC($data,$key){

		# Opens the module of the algorithm and the mode to be used
		$algorithm = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '','cfb', '');
		
		$iv_size = mcrypt_enc_get_iv_size($algorithm);				// Returns the size of the IV of the opened algorithm
		$data = base64_decode($data);								// Decodes data encoded with MIME base64
		//$data	= unserialize(gzuncompress(stripslashes(base64_decode(strtr($data, '-_', '+=')))));
		$iv = substr($data,0,$iv_size);								// Return part of a string
		$data = substr($data,$iv_size);
		
		$key = md5($key);											// Calculate the md5 hash of a string
		$key = substr($key, 0, mcrypt_enc_get_key_size($algorithm));// Returns the maximum supported keysize of the opened mode
		
		if (mcrypt_generic_init($algorithm, $key, $iv) === 0){ 		// This function initializes all buffers needed for encryption
			
			$decryptedtext = mdecrypt_generic($algorithm, $data);	// Decrypt data
			mcrypt_generic_deinit($algorithm);						// This function deinitializes an encryption module
			mcrypt_module_close($algorithm);						// Close the mcrypt module
			return $decryptedtext;
		}
		
		return $data;
	}
}


/*
 * ------------------------------------------------------------ Tests ------------------------------------------------------------
 */
/*
$encription = new Encryption();

$encrypted = $encription->encryptCC('1234234563234562','4563');
echo $encrypted."<br/><br/><br/><br/>";

$decrypted = $encription->decryptCC($encrypted,'4563');
echo $decrypted."<br/><br/><br/><br/>";

echo $_SERVER['HTTP_USER_AGENT'];
*/
?>
