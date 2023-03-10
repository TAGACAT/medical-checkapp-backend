			<?php
			
			class News
			{
				public function _construct()
				{}
				
				public function _destruct()
				{}	
				
				public function ValidarUsuario($user, $password)
				{					
							$hostName = "localhost";
							$databaseName = "medicinabd";
							$hostUser = "medicina";
							$hostPassword = "mdb2984";
				
							$databaseConn = mysql_connect($hostName,$hostUser,$hostPassword);
							$existsDatabase = mysql_select_db($databaseName,$databaseConn);
						
							if( $existsDatabase )
							{
								$query = "SELECT * FROM Administrator WHERE user = '$user' AND password = '$password'";
								$queryResource = mysql_query($query);
							
								if( $queryResource == false)
								{
									mysql_close($databaseConn);
									return -1;					
								}	
								else
								{
									$existsUser = mysql_affected_rows();
									mysql_close($databaseConn);
									if( $existsUser == 0 )
										return 0;
									else if( $existsUser == 1 )		
										return 1;				
								}
							}
							else
							{
								mysql_close($databaseConn);
								return -1;
							}						
				}
				
				public function RegistrarNoticia($newsSPA, $newsENG, $newsFRE, $newsITA, $newsGER, $newsLink1, $newsLink2, $newsLink3)
				{
							$host_name = "localhost";
							$database_name = "medicinabd";
							$host_user = "medicina";
							$host_password = "mdb2984";
				
							$database_connection = mysql_connect($host_name,$host_user,$host_password);
							$exists_database = mysql_select_db($database_name,$database_connection);
						
							if( $exists_database )
							{
								$query = "INSERT INTO News (newsSPA, newsENG, newsFRE, newsITA, newsGER, newsLink1, newsLink2, newsLink3)". 
										 "VALUES ('$newsSPA', '$newsENG', '$newsFRE', '$newsITA', '$newsGER', '$newsLink1', '$newsLink2', '$newsLink3')";	
										 
								$query_success = mysql_query($query);
								
								if( $query_success == true )
								{
									$newsID = mysql_insert_id(); /*Deberia ser mayor a cero.*/
									mysql_close($database_connection);
									return $newsID; 
								}	
								else if( $query_success == false ) 
								{
									mysql_close($database_connection);
									return 0;
								}
							}	
							else 
							{
								mysql_close($database_connection);
								return -1;
							}
				}
			}
			?>		

