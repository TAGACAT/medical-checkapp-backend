<?php
    
class Sets
{
	function getStatusCodeMessage($status) 
	{
		$codes = Array(
		100 => 'Continue', 
		101 => 'Switching Protocols', 
		200 => 'OK', 201 => 'Created', 
		202 => 'Accepted', 
		203 => 'Non-Authoritative Information', 
		204 => 'No Content', 
		205 => 'Reset Content', 
		206 => 'Partial Content', 
		300 => 'Multiple Choices', 
		301 => 'Moved Permanently', 
		302 => 'Found', 
		303 => 'See Other', 
		304 => 'Not Modified', 
		305 => 'Use Proxy', 
		306 => '(Unused)', 
		307 => 'Temporary Redirect', 
		400 => 'Bad Request', 
		401 => 'Unauthorized', 
		402 => 'Payment Required', 
		403 => 'Forbidden', 
		404 => 'Not Found', 
		405 => 'Method Not Allowed', 
		406 => 'Not Acceptable', 
		407 => 'Proxy Authentication Required', 
		408 => 'Request Timeout', 
		409 => 'Conflict', 
		410 => 'Gone', 
		411 => 'Length Required', 
		412 => 'Precondition Failed', 
		413 => 'Request Entity Too Large', 
		414 => 'Request-URI Too Long', 
		415 => 'Unsupported Media Type', 
		416 => 'Requested Range Not Satisfiable', 
		417 => 'Expectation Failed', 
		500 => 'Internal Server Error', 
		501 => 'Not Implemented', 
		502 => 'Bad Gateway', 
		503 => 'Service Unavailable', 
		504 => 'Gateway Timeout', 
		505 => 'HTTP Version Not Supported');

		return (isset($codes[$status])) ? $codes[$status] : '';
	}

	function sendResponse($status = 200, $body = '', $content_type = 'text/html') {
		/*$status_header = 'HTTP/1.1 ' . $status . ' ' . $this -> getStatusCodeMessage($status);
		header($status_header);
		header('Content-type: ' . $content_type);*/
		echo $body;
		exit;
	}
	
	function __construct() 
	{}
	
	function __destruct()
	{}
	
	function ObtenerSets()
	{
		if( isset($_POST['idioma']) ) //Puede ser ENG, SPA, GER, ITA y FRE
		{
			$idioma = strval($_POST['idioma']);
			$idioma = strtoupper($idioma);
			if( strcmp($idioma, "ENG") == 0 || strcmp($idioma, "SPA") == 0 || strcmp($idioma, "GER") == 0 || strcmp($idioma, "ITA") == 0 || strcmp($idioma, "FRE") == 0 )	
			{
				//El idioma esta dentro de los 5 permitidos
				$hostName = "localhost";
				$databaseName = "medicinabd";
				$hostUser = "medicina";
				$hostPassword = "mdb2984";
			
				$databaseConn = mysql_connect($hostName,$hostUser,$hostPassword);
				$existsDatabase = mysql_select_db($databaseName,$databaseConn);
			
				if($existsDatabase)
				{		
					//Armo el query dependiendo del idioma.
					$query = "";
					if( strcmp($idioma, "ENG") == 0 ) //El idioma es el ingles.
						$query = "SELECT DISTINCT SetENG FROM Comment WHERE Avaliable = 1";
					else if( strcmp($idioma, "SPA") == 0 ) //El idioma es el espanol.
						$query = "SELECT DISTINCT SetSPA FROM Comment WHERE Avaliable = 1";
					else if( strcmp($idioma, "GER") == 0 ) //El idioma es el aleman.
						$query = "SELECT DISTINCT SetGER FROM Comment WHERE Avaliable = 1";
					else if( strcmp($idioma, "ITA") == 0 ) //El idioma es el italiano.
						$query = "SELECT DISTINCT SetITA FROM Comment WHERE Avaliable = 1";
					else if( strcmp($idioma, "FRE") == 0 ) //El idioma es el frances.
						$query = "SELECT DISTINCT SetFRE FROM Comment WHERE Avaliable = 1";
					
					//Ejecuto el query
					$queryResource = mysql_query($query);
					
					//Armo el array para hacerle json_encode
					$tempArray = array();
					while( $queryRow = mysql_fetch_array($queryResource) )
					{
						if( strcmp($idioma, "ENG") == 0 )
							$tempArray[] = array("set" => utf8_encode($queryRow['SetENG']));
						else if( strcmp($idioma, "SPA") == 0 )
							$tempArray[] = array("set" => utf8_encode($queryRow['SetSPA']));
						else if( strcmp($idioma, "GER") == 0 )
							$tempArray[] = array("set" => utf8_encode($queryRow['SetGER']));
						else if( strcmp($idioma, "ITA") == 0 )
							$tempArray[] = array("set" => utf8_encode($queryRow['SetITA']));
						else if( strcmp($idioma, "FRE") == 0 )
							$tempArray[] = array("set" => utf8_encode($queryRow['SetFRE']));
					}
					
					$queryResult = array("sets" => $tempArray);
					mysql_close($databaseConn);
					$this->sendResponse(200, json_encode($queryResult));
				}
				else
				{
					$queryResult = array("sets" => array());
					mysql_close($databaseConn);
					$this->sendResponse(200, json_encode($queryResult));
				}
			}
			else 
			{
				$queryResult = array("sets" => array());
				$this->sendResponse(200, json_encode($queryResult));		
			}
		}
		else 
		{
			$queryResult = array("sets" => array());
			$this->sendResponse(200, json_encode($queryResult));
		}
	}
}    

$sets = new Sets();
$sets->ObtenerSets(); 
        
?>