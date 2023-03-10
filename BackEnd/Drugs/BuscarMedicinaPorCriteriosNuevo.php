<?php
//error_reporting(E_ALL);
//ini_set('display_errors','On');
//header('Content-Type: application/json; charset=UTF-8');

class Medicina
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
		if($status==200)
			echo $body;
		else
			echo json_encode(array("status" => $status, "message"=>$body));
		
		exit;
	}
	
	function __construct() 
	{}
	
	function __destruct()
	{}
	
	function BuscarMedicinaCriterios()
	{
		if (isset($_POST['texto']))
		{
			$host_name = "localhost";
			$database_name = "medicinabd";
			$host_user = "medicina";
			$host_password = "mdb2984";
			
			$database_conn = mysql_connect($host_name,$host_user,$host_password);
			$exists_database = mysql_select_db($database_name,$database_conn);
			
			if ($exists_database)
			{
				$texto = $_POST['texto'];
				//$limite_inferior = intval($_POST['limiteInferior']);
				//$cantidad = intval($_POST['cantidad']);
						
				$temp_array = array();
				
				$query = "SELECT a.*, b.SponsorApplicant FROM Drug a
				Left Join Company b on a.AppINo = b.AppINo
				WHERE upper(a.Drugname) LIKE upper('%$texto%') OR upper(a.Activeingred) LIKE upper('%$texto%') ";
				//ORDER BY Drugname ASC LIMIT $limite_inferior,$cantidad";
				$query .= " Order By a.Drugname ASC ";

				$pagina = "";
				if (isset($_POST['pagina']) )
					$pagina = $_POST["pagina"];
				
				$registros = "";
				if (isset($_POST['registros']) )
					if(is_numeric($_POST["registros"]))
						$registros = $_POST["registros"];
		
				if($pagina!="")
					if($pagina!="-1")
						if($registros!="")
							if($registros > 0)
								$query.= " Limit ". $pagina*$registros . ", ". $registros;
								
				$query_resource = mysql_query($query);
				
				if (mysql_affected_rows() > 0)	
				{					
					while ($query_row = mysql_fetch_assoc($query_resource))	
					{
						$temp_array[] = array(
											  "DrugsPK" => $query_row['DrugsPK'],							  
											  "AppINo" => $query_row['AppINo'], 
											  "Form" => $query_row['Form'], 
											  "Dosage" => $query_row['Dosage'], 
											  "Drugname" => $query_row['Drugname'],
											  "Activeingred" => $query_row['Activeingred']
											  , "SponsorApplicant" => $query_row['SponsorApplicant']
										 	);
					}
					
					$query_total_consultados  = "SELECT * FROM Drug WHERE upper(Drugname) LIKE upper('%$texto%') OR upper(Activeingred) LIKE upper('%$texto%') ";
					$query_total_consultados  .= " Limit 0, ". $registros*($pagina+1);
					$query_resource_total_consultados = mysql_query($query_total_consultados);
					$cantidad_total_consultados =  mysql_num_rows($query_resource_total_consultados);
					
					$query_total = "SELECT * FROM Drug WHERE upper(Drugname) LIKE upper('%$texto%') OR upper(Activeingred) LIKE upper('%$texto%') ";
					$query_resource_total = mysql_query($query_total);
					$cantidad_total =  mysql_num_rows($query_resource_total);
					$cantidad_faltante = $cantidad_total - $cantidad_total_consultados;// - ($limite_inferior + $cantidad);
					
					$query_result = array("CodError" => 0,"Drugs" => $temp_array, "Cantidad" => $cantidad_faltante); 
					mysql_close($database_conn);
					$this->sendResponse(200,json_encode($query_result));
				}		
				else
				{
					$query_result = array("CodError" => 3,"Drugs" => array(), "Cantidad" => -1); 
					mysql_close($database_conn);
					$this->sendResponse(200,json_encode($query_result));	
				}
			}
			else
			{
				$query_result = array("CodError" => 2,"Drugs" => array(), "Cantidad" => -1); 
				mysql_close($database_conn);
				$this->sendResponse(200,json_encode($query_result)); 
			}
		}
		else
		{
			$query_result = array("CodError" => 1,"Drugs" => array(), "Cantidad" => -1); 
			$this->sendResponse(200,json_encode($query_result));
		}
	}
}

$medicine = new Medicina();
$medicine->BuscarMedicinaCriterios();
?>