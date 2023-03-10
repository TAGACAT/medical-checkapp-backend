<?php

class Versioning
{
	function getStatusCodeMessage($status) 
	{
		$codes = Array(100 => 'Continue', 101 => 'Switching Protocols', 200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 
		204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content', 300 => 'Multiple Choices', 301 => 'Moved Permanently', 
		302 => 'Found', 303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', 306 => '(Unused)', 307 => 'Temporary Redirect', 400 => 'Bad Request', 
		401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable', 
		407 => 'Proxy Authentication Required', 408 => 'Request Timeout', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 
		413 => 'Request Entity Too Large', 414 => 'Request-URI Too Long', 415 => 'Unsupported Media Type', 416 => 'Requested Range Not Satisfiable', 
		417 => 'Expectation Failed', 500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable', 
		504 => 'Gateway Timeout', 505 => 'HTTP Version Not Supported');

		return (isset($codes[$status])) ? $codes[$status] : '';
	}
	
	function sendResponse($status = 200, $body = '', $content_type = 'text/html') 
	{
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
		
	function ObtenerVersionTabla()
	{
		if (isset($_POST['nombreTabla']))
		{
			$host_name = "localhost";
			$database_name = "medicinabd";
			$host_user = "medicina";
			$host_password = "mdb2984";
			
			$database_conn = mysql_connect($host_name,$host_user,$host_password);
			$exists_database = mysql_select_db($database_name,$database_conn);

			if ($exists_database)
			{	
				$nombre_tabla = strval($_POST['nombreTabla']);
				$query = "SELECT VersioningInt FROM TablesVersioning WHERE VersioningTable = '$nombre_tabla' ORDER BY VersioningInt DESC LIMIT 1";		
				$queryResult = mysql_query($query);
						 	
				if (mysql_affected_rows() > 0)
				{
					$queryRow = mysql_fetch_assoc($queryResult);
					$resultado =  array('CodError' => 0, 'VersionTabla' => $queryRow['VersioningInt']);
					mysql_close($database_conn);
					$this->sendResponse(200, json_encode($resultado));	
				}
				else 
				{
					$resultado[] =  array('CodError' => 3, 'VersionTabla' => 0);
					mysql_close($database_conn);
					$this->sendResponse(200, json_encode($resultado));
				}				
			}
			else
			{
				$resultado[] =  array('CodError' => 2, 'VersionTabla' => 0);
				mysql_close($database_conn);
				$this->sendResponse(200, json_encode($resultado));
			}
		}
		else
		{
			$resultado[] =  array('CodError' => 1, 'VersionTabla' => 0);
			$this->sendResponse(200, json_encode($resultado));
		}
	}
}

$version = new Versioning();
$version-> ObtenerVersionTabla();

?>