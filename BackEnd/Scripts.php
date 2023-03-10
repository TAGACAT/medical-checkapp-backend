<?php

class Scripts
{
	function __construct() 
	{}
	
	function __destruct()
	{}
	
	function InsertMedicinesIntoDatabase()
	{
		ini_set("auto_detect_line_endings", true);		
		if( ($handle = fopen("Product.csv", "r")) != FALSE )
		{		
			$hostName = "localhost";
			$databaseName = "medicinabd";
			$hostUser = "medicina";
			$hostPassword = "mdb2984";
			
			$databaseConn = mysql_connect($hostName,$hostUser,$hostPassword);
			$existsDatabase = mysql_select_db($databaseName,$databaseConn);
			
			if($existsDatabase)
			{
				$productsColumn = fgetcsv($handle, 1000, ",");
				
				while( ($data = fgetcsv($handle, 1000, ",")) != FALSE )
				{			
					$AppINo = $data[0];
					$Form = $data[1];	
					if(strlen($Form) > 0) 
						$Form = str_replace(";","\;",$Form); 
					$Dosage = $data[2]; 
					if(strlen($Dosage) > 0) 
						$Dosage = str_replace(";","\;",$Dosage);
					$Drugname = $data[3]; 
					if(strlen($Drugname) > 0) 
						$Drugname = str_replace(";","\;",$Drugname);
					$Activeingred = $data[4]; 
					if(strlen($Activeingred) > 0) 
						$Activeingred = str_replace(";","\;",$Activeingred);

					$query = "INSERT INTO Drug (AppINo,Form,Dosage,Drugname,Activeingred) VALUES ('$AppINo','$Form','$Dosage','$Drugname','$Activeingred')";
					mysql_query($query);
					
					if(mysql_affected_rows() == 0)
						echo "No se registro el medicamente $ProductNo en la base de datos";
					else if(mysql_affected_rows() == 1)
						echo "Se registro el medicamente $ProductNo en la base de datos";
				}

				mysql_close($databaseConn);
				fclose($handle);
			}
			else
			{
				echo "No existe la base de datos";		
			}
		}
		else
		{
			echo "No existe el archivo Product.csv";		
		}
	}

	function InsertCompaniesIntoDatabase()
	{
		ini_set("auto_detect_line_endings", true);		
		if( ($handle = fopen("Application.csv", "r")) != FALSE )
		{		
			$hostName = "localhost";
			$databaseName = "medicinabd";
			$hostUser = "medicina";
			$hostPassword = "mdb2984";
			
			$databaseConn = mysql_connect($hostName,$hostUser,$hostPassword);
			$existsDatabase = mysql_select_db($databaseName,$databaseConn);
			
			if($existsDatabase)
			{
				$columns = fgetcsv($handle, 1000, ",");
				
				while( ($data = fgetcsv($handle, 1000, ",")) != FALSE )
				{			
					$AppINo = $data[0];
					$SponsorApplicant = $data[1];	

					$query = "INSERT INTO Company (AppINo, SponsorApplicant) VALUES ('$AppINo','$SponsorApplicant')";
					mysql_query($query);
					
					if(mysql_affected_rows() == 0)
						echo "No se registro el medicamente $ProductNo en la base de datos";
					else if(mysql_affected_rows() == 1)
						echo "Se registro el medicamente $ProductNo en la base de datos";
				}
				
				mysql_close($databaseConn);
				fclose($handle);
			}
			else
			{
				echo "No existe la base de datos";		
			}
		}
		else
		{
			echo "No existe el archivo Product.csv";		
		}
	}
	
	function InsertTestsIntoDatabase()
	{
		ini_set("auto_detect_line_endings", true);		
		if( ($handle = fopen("Tests.csv", "r")) != FALSE )
		{		
			$hostName = "localhost";
			$databaseName = "medicinabd";
			$hostUser = "medicina";
			$hostPassword = "mdb2984";
			
			$databaseConn = mysql_connect($hostName,$hostUser,$hostPassword);
			$existsDatabase = mysql_select_db($databaseName,$databaseConn);
			
			mysql_query ("SET NAMES 'utf8'");
			
			if($existsDatabase)
			{
				$columns = fgetcsv($handle, 1000, ",");
				while( ($data = fgetcsv($handle, 1000, ",")) != FALSE )
				{			
					$TestENG = $data[0];
					$TestESP = $data[1];
					$TestGER = $data[2];
					$TestFRE = $data[3];
					$TestITA = $data[4];
					$Gender = $data[5];
					
					$Unit1 = $data[6];
					$Range1 = $data[7];
					$Default1 = $data[8];
					$Step1 = $data[9];
					$Line11 = $data[10];
					$Line12 = $data[11];
					$Line13 = $data[12];
					
					$Unit2 = $data[13];
					$Range2 = $data[14];
					$Default2 = $data[15];
					$Step2 = $data[16];
					$Line21 = $data[17];
					$Line22 = $data[18];
					$Line23 = $data[19];				

					echo "INSERT INTO Test (TestENG,TestESP,TestGER,TestFRE,TestITA,Gender,Unit1,Range1,Default1,Step1,Line11,Line12,Line13,Unit2,Range2,Default2,Step2,Line21,Line22,Line23) VALUES ('$TestENG','$TestESP','$TestGER','$TestFRE','$TestITA','$Gender','$Unit1','$Range1','$Default1','$Step1','$Line11','$Line12','$Line13','$Unit2','$Range2','$Default2','$Step2','$Line21','$Line22','$Line23')";
					$query = "INSERT INTO Test (TestENG,TestESP,TestGER,TestFRE,TestITA,Gender,Unit1,Range1,Default1,Step1,Line11,Line12,Line13,Unit2,Range2,Default2,Step2,Line21,Line22,Line23) VALUES ('$TestENG','$TestESP','$TestGER','$TestFRE','$TestITA','$Gender','$Unit1','$Range1','$Default1','$Step1','$Line11','$Line12','$Line13','$Unit2','$Range2','$Default2','$Step2','$Line21','$Line22','$Line23')";
					mysql_query($query);
					
					if(mysql_affected_rows() == 0)
						echo "No se registro el medicamente $ProductNo en la base de datos";
					else if(mysql_affected_rows() == 1)
						echo "Se registro el medicamente $ProductNo en la base de datos";
				}
				
				mysql_close($databaseConn);
				fclose($handle);
			}
			else
			{
				echo "No existe la base de datos";		
			}
		}
		else
		{
			echo "No existe el archivo Product.csv";		
		}
	}
}

$script = new Scripts();
    
//$script->InsertMedicinesIntoDatabase();	
//$script->InsertCompaniesIntoDatabase();	
//$script->InsertTestsIntoDatabase();	

?>