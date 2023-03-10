<?php

class Level
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
		
	function ObtenerLevels()
	{
		if( isset($_POST['idioma']) && isset($_POST['set']) ) //ENG, SPA, GER, ITA o FRE
		{
			$idioma = strval($_POST['idioma']);
			//$idioma = "ger";
			$idioma = strtoupper($idioma);
			if( strcmp($idioma, "ENG") == 0 || strcmp($idioma, "SPA") == 0 || strcmp($idioma, "GER") == 0 || strcmp($idioma, "ITA") == 0 || strcmp($idioma, "FRE") == 0 )	
			{
				$hostName = "localhost";
				$databaseName = "medicinabd";
				$hostUser = "medicina";
				$hostPassword = "mdb2984";
			
				$databaseConn = mysql_connect($hostName,$hostUser,$hostPassword);
				$existsDatabase = mysql_select_db($databaseName,$databaseConn);
			
				if($existsDatabase)
				{
					$set = strval($_POST['set']);
					//$set = "Symptome";
					$query = "";
					if( strcmp($idioma, "ENG") == 0 ) //El idioma es el ingles.
						$query = "SELECT DISTINCT C.Level, L.LevelName FROM Comment AS C, Level AS L WHERE C.Level = L.LevelCode AND C.SetENG = '$set' AND Avaliable = 1";
					else if( strcmp($idioma, "SPA") == 0 ) //El idioma es el espanol.
						$query = "SELECT DISTINCT C.Level, L.LevelName FROM Comment AS C, Level AS L WHERE C.Level = L.LevelCode AND C.SetSPA = '$set' AND Avaliable = 1";
					else if( strcmp($idioma, "GER") == 0 ) //El idioma es el aleman.
						$query = "SELECT DISTINCT C.Level, L.LevelName FROM Comment AS C, Level AS L WHERE C.Level = L.LevelCode AND C.SetGER = '$set' AND Avaliable = 1";
					else if( strcmp($idioma, "ITA") == 0 ) //El idioma es el italiano.
						$query = "SELECT DISTINCT C.Level, L.LevelName FROM Comment AS C, Level AS L WHERE C.Level = L.LevelCode AND C.SetITA = '$set' AND Avaliable = 1";
					else if( strcmp($idioma, "FRE") == 0 ) //El idioma es el frances.
						$query = "SELECT DISTINCT C.Level, L.LevelName FROM Comment AS C, Level AS L WHERE C.Level = L.LevelCode AND C.SetFRE = '$set' AND Avaliable = 1";
						
					$queryResource = mysql_query($query);
					
					$tempArray = array();
					while( $queryRow = mysql_fetch_array($queryResource) )
					{
						$tempArray[] = array("leveCode" => $queryRow['Level'], "levelName" => utf8_encode($queryRow['LevelName']));
					}
					
					$queryResult = array("levels" => $tempArray);
					mysql_close($databaseConn);
					$this->sendResponse(200, json_encode($queryResult));
				}
				else
				{
					$queryResult = array("levels" => array());
					mysql_close($databaseConn);
					$this->sendResponse(200, json_encode($queryResult));
				}	
			}	
			else 
			{
				$queryResult = array("levels" => array());
				$this->sendResponse(200, json_encode($queryResult));
			}	
		}
		else
		{
			$queryResult = array("levels" => array());
			$this->sendResponse(200, json_encode($queryResult));	
		}
	}
}

$level = new Level();
$level->ObtenerLevels();

?>