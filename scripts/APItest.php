<?php

function search($source){
	require("apiconfig.inc");
	$curl = curl_init();

	//returns error message should executing $curl fail
	//if (!curl_exec($curl)) {
	//        die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
	//}
	// Set some options, we are passing in a useragent too 
	curl_setopt_array($curl, [
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL =>"http://open.api.ebay.com/shopping?callname=FindProducts&responseencoding=JSON&siteid=0&version=967&QueryKeywords=$source&AvailableItemsOnly=true&MaxEntries=5&appid=$apikey",
		CURLOPT_USERAGENT => 'API sample cURL Request for sneakers',
	]);
	//send the request & save the response to $resp
	$resp = curl_exec($curl);
	//echo the response
	echo $resp;
	//close request to clear up some resources
	curl_close($curl);
	/*NEW CODE
	foreach($resp -> searchResult -> item -> as $item)
		{
			$apiArray[$input] = array(
			"pic" => $item -> galleryURL;
			"link" => $item -> viewItemURL;
			"title" => $item -> title;
			"price" => $item -> sellingStatus -> currentPrice;
			);
		}

	}
	*/
	return $resp;
	//return $apiArray;

}
//---------------------------------------------------------------------------------------------------------------------------------


?>

