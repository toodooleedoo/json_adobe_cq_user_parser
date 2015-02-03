<?php
	ini_set('memory_limit', '-1');
	if (!isset($_REQUEST['env'])) {
 		$env="prod";
		$username="admin";
		$password="admin";
		$server="<<<CUT>>>";
	} 

	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $server."/bin/security/authorizables.json?_dc=1374081128446&start=0&limit=5&_charset_=utf-8&filter=&hideGroups=true");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "sling.sudo=$user",
            "cqpsso=admin",
            "sm_user: $user"
            ));
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $json= curl_exec($ch);

	$json = utf8_encode($json);
	$obj = json_decode($json);
	$strContent='';
	foreach($obj->{'authorizables'} as $key) {
		@$strContent.=$key->{'rep:userId'};
		$strContent.=',';
		@$strContent.=$key->{'name'};
		$strContent.=',';
		@$strContent.=$key->{'email'};
		foreach($key->{'memberOf'} as $member) {
			@$strContent.=$member->{'name'};
			$strContent.=',';
		}
		$strContent.='	'.PHP_EOL;
		//var_dump($key);

	}
	//echo $strContent;
	file_put_contents('./users.csv',$strContent);
	echo $strContent;
	//var_dump($obj);
?>
