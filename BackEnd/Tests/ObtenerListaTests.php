<?php

class Test
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
		header("Content-Type: text/html; charset=utf-8");
		echo $body;
		exit;
	}
	
	function __construct() 
	{}
	
	function __destruct()
	{}

	function ObtenerListaTests()
	{
		if( isset($_POST['idioma']) && isset($_POST['genero']) )
		{
			$idioma = $_POST['idioma'];
			$genero = $_POST['genero'];
			/*$idioma = "SPA";
			$genero = "M";*/
			$idioma = strtoupper($idioma);
			$genero = strtoupper($genero);
			
			if( (strcmp($idioma, "SPA") == 0 || strcmp($idioma, "ENG") == 0 || strcmp($idioma, "GER") == 0 || strcmp($idioma, "FRE") == 0 
				|| strcmp($idioma, "ITA") == 0) && (strcmp($genero, "M") == 0 || strcmp($genero, "F") == 0) ) /*Si el idioma es alguno de los 5*/
			{					
				$hostName = "localhost";
				$databaseName = "medicinabd";
				$hostUser = "medicina";
				$hostPassword = "mdb2984";
			
				$databaseConn = mysql_connect($hostName,$hostUser,$hostPassword);
				$existsDatabase = mysql_select_db($databaseName,$databaseConn);
				
				if($existsDatabase)
				{
					$query = "SELECT * FROM Test WHERE Gender = '$genero' OR Gender = '-'";	
					
					$queryResult = mysql_query($query);
					$tempArray = array();
					
					while($queryRow = mysql_fetch_array($queryResult))
					{
						if( strcmp($idioma, "SPA") == 0 ) 
						{
							$tempArray[] = array("id" => $queryRow['TestID'], 
											"test" => utf8_encode($queryRow['TestESP']), 
											"unit1" => utf8_encode($queryRow['Unit1']), 
											"unit2" => utf8_encode($queryRow['Unit2']));
						}
						if( strcmp($idioma, "ENG") == 0 ) 
						{
							$tempArray[] = array("id" => $queryRow['TestID'], 
											"test" => utf8_encode($queryRow['TestENG']), 
											"unit1" => utf8_encode($queryRow['Unit1']), 
											"range1" => utf8_encode($queryRow['Range1']),
											"default1" => utf8_encode($queryRow['Default1']),
											"step1" => utf8_encode($queryRow['Step1']),
											"line11" => utf8_encode($queryRow['Line11']),
											"line12" => utf8_encode($queryRow['Line12']),
											"line13" => utf8_encode($queryRow['Line13']),
											"unit2" => utf8_encode($queryRow['Unit2']),
											"range2" => utf8_encode($queryRow['Range2']),
											"default2" => utf8_encode($queryRow['Default2']),
											"step2" => utf8_encode($queryRow['Step2']),
											"line21" => utf8_encode($queryRow['Line21']),
											"line22" => utf8_encode($queryRow['Line22']),
											"line23" => utf8_encode($queryRow['Line23']));
						}
						if( strcmp($idioma, "FRE") == 0 ) 
						{
							$tempArray[] = array("id" => $queryRow['TestID'], 
											"test" => utf8_encode($queryRow['TestFRE']), 
											"unit1" => utf8_encode($queryRow['Unit1']), 
											"unit2" => utf8_encode($queryRow['Unit2']));
						}
						if( strcmp($idioma, "GER") == 0 ) 
						{
							$tempArray[] = array("id" => $queryRow['TestID'], 
											"test" => utf8_encode($queryRow['TestGER']), 
											"unit1" => utf8_encode($queryRow['Unit1']), 
											"unit2" => utf8_encode($queryRow['Unit2']));
						}
						if( strcmp($idioma, "ITA") == 0 ) 
						{
							$tempArray[] = array("id" => $queryRow['TestID'], 
											"test" => utf8_encode($queryRow['TestITA']), 
											"unit1" => utf8_encode($queryRow['Unit1']), 
											"unit2" => utf8_encode($queryRow['Unit2']));
						}
					}
					
					$resultArray = array("CodError" => 0,"Tests" => $tempArray);
					mysql_close($databaseConn);
					$this->sendResponse(200,json_encode($resultArray));
				}
				else 
				{
					$resultArray = array("CodError" => 3,"Tests" => array());
					mysql_close($databaseConn);
					$this->sendResponse(200,json_encode($resultArray));
				}				
			}
			else 
			{
				$resultArray = array("CodError" => 2, "Tests" => array());
				$this->sendResponse(200, json_encode($resultArray));
			}
		}
		else
		{
			$resultArray = array("CodError" => 1, "Tests" => array());
			$this->sendResponse(200, json_encode($resultArray));	
		}
	}
}

$test = new Test();

$test->ObtenerListaTests();
	
?>