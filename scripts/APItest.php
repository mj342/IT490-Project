<?php

function search($source)
{
	require("apiconfig.inc");
	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL =>"http://open.api.ebay.com/shopping?callname=FindProducts&responsencoding=JSON&siteid=0&version=967&QueryKeywords=$source&AvailableItemsOnly=true&MaxEntries=41&appid=$apikey",
		CURLOPT_USERAGENT => 'API sample cURL Request for sneakers',
	]);
	//send the request & save the response to $resp
	$resp = curl_exec($curl);
	//echo the response
	//echo $resp;
	//close request to clear up some resources
	curl_close($curl);
	return $resp;
}	




?>

