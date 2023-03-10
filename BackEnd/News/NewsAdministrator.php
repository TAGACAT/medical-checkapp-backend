<html>
	<head>
		<title>
			Administrador de noticias - Medical Checkapp
		</title>
		<center>
			<label style="font-size: 20"> Administrador de noticias - Medical Checkapp  </label>
		</center>
	</head>
	<body>
		<form method="POST" action="<?php $PHP_SELF; ?>">
			<center>
				<table>
					<tr>
						<td colspan="2" align="left" height="50">
							Enter the news in the respective language:
						</td>
					</tr>
					<tr>
						<td valign="top">
							Spanish:	
						</td>
						<td>
							<textarea name="newsSPA" rows="5" cols="80"></textarea>
						</td>
					</tr>
					<tr>
						<td valign="top">
							English:	
						</td>
						<td>
							<textarea name="newsENG" rows="5" cols="80"></textarea>
						</td>
					</tr>
					<tr>
						<td valign="top">
							French:	
						</td>
						<td>
							<textarea name="newsFRE" rows="5" cols="80"></textarea>
						</td>
					</tr>
					<tr>
						<td valign="top">
							Italian:	
						</td>
						<td>
							<textarea name="newsITA" rows="5" cols="80"></textarea>
						</td>
					</tr>
					<tr>
						<td valign="top">
							German:	
						</td>
						<td>
							<textarea name="newsGER" rows="5" cols="80"></textarea>
						</td>
					</tr>
					<tr>
						<td valign="top">
							Link 1:	
						</td>
						<td>
							<textarea name="newsLink1" rows="1" cols="80"></textarea>
						</td>
					</tr>
					<tr>
						<td valign="top">
							Link 2:	
						</td>
						<td>
							<textarea name="newsLink2" rows="1" cols="80"></textarea>
						</td>
					</tr>
					<tr>
						<td valign="top">
							Link 2:	
						</td>
						<td>
							<textarea name="newsLink3" rows="1" cols="80"></textarea>
						</td>
					</tr>		
					<tr>
						<td colspan="2" height="50">
							<center>
								<input type="submit" name="submit" value="Save news" /> &nbsp; &nbsp; &nbsp; &nbsp; 
								<input type="reset" name="reset" value="Clean"/>
							</center>
						</td>
					</tr>			
				</table>
			</center>
		</form>	
		
		<?php
		
		if( isset($_POST['submit']) )
		{
			include("News.php");
			$news = new News();
			
			$news_SPA = $_POST['newsSPA'];
			$news_ENG = $_POST['newsENG'];
			$news_FRE = $_POST['newsFRE'];
			$news_ITA = $_POST['newsITA'];
			$news_GER = $_POST['newsGER'];
			$news_Link1 = $_POST['newsLink1'];
			$news_Link2 = $_POST['newsLink2'];
			$news_Link3 = $_POST['newsLink3'];
			
			if( strlen($news_SPA) == 0 ) $news_SPA = "-"; else	$news_SPA = str_replace("'", "/'", $news_SPA);
			if( strlen($news_ENG) == 0 ) $news_ENG = "-"; else	$news_ENG = str_replace("'", "/'", $news_ENG);
			if( strlen($news_FRE) == 0 ) $news_FRE = "-"; else	$news_FRE = str_replace("'", "/'", $news_FRE);
			if( strlen($news_ITA) == 0 ) $news_ITA = "-"; else	$news_ITA = str_replace("'", "/'", $news_ITA);
			if( strlen($news_GER) == 0 ) $news_GER = "-"; else	$news_GER = str_replace("'", "/'", $news_GER);
			if( strlen($news_Link1) == 0 ) $news_Link1 = "-"; else 	$news_Link1 = str_replace("'", "/'", $news_Link1);
			if( strlen($news_Link2) == 0 ) $news_Link2 = "-"; else	$news_Link2 = str_replace("'", "/'", $news_Link2);
			if( strlen($news_Link3) == 0 ) $news_Link3 = "-"; else	$news_Link3 = str_replace("'", "/'", $news_Link3);
			
			echo $news_SPA;
			echo $news_ENG;
			
			$news_id = $news->RegistrarNoticia($news_SPA, $news_ENG, $news_FRE, $news_ITA, $news_GER, $news_Link1, $news_Link2, $news_Link3);
			
			$mensaje = "";
			if( $news_id == 0 )
				$mensaje = "Error: Could not save the news. Try again later.";
			else if( $news_id == -1)
				$mensaje = "Error: Could not save the news. Contact with the developers.";
			else if( $news_id > 0 )
				$mensaje = "The news were saved. News code: $news_id";
			
			echo "<script> alert('$mensaje') </script>";
		}
		
		?>
		
	</body>
</html>