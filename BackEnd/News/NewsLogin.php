<html>
	<head>
		<title> 
			Administrador de noticias - Medical Checkapp 
		</title>
		<center>
			<label style="font-size: 20"> Administrador de noticias - Medical Checkapp </label>
		</center>
	</head>
	<body>
		<form method="post" action="<?php print $PHP_SELF; ?>">
			<center>
				<table>
					<tr>
						<td>
							User:
						</td>
						<td>
							<input type="text" name="user" style="font-size: 13" />
					</tr>
					<tr>
						<td>
							Password:
						</td>
						<td>
							<input type="password" name="password" style="font-size: 13" />
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<input type="submit" value="Ingresar" name="submit"/>
						</td>
					</tr>
				</table>				
			</center>	
		</form>			
					
			<?php	
				if( isset($_POST['submit']) ) //No estan dentro de la matriz $_REQUEST inicialmente.
				{
					include("News.php");					
					$news = new News();
					
					$user = $_POST['user'];
					$password = $_POST['password'];
					if( $user != "" && $password != "" )
					{
						$existeUsuario = $news->ValidarUsuario($user, $password);
						if( $existeUsuario == -1 )
							print "<p style:'text-align: center'>"."Try again later."."</p>";
						else if( $existeUsuario == 0 )
							print "<p style:'text-align: center'>"."The user '$user' does not exists. Verify the user and password."."</p>";
						else if( $existeUsuario == 1)
							header("Location: http://www.onlinestudioproductions.com/medicineapp/News/NewsAdministrator.php");
					}
					else
						print "<p style='text-align: center'>"."Complete all the fields, please"."</p>";
				}	
				else
				{ 	
					print " ";
				}
			?>
			
	</body>	
</html>
