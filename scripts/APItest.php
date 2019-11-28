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
		CURLOPT_URL =>"http://open.api.ebay.com/shopping?callname=FindProducts&responsencoding=JSON&siteid=0&version=967&QueryKeywords=$source&AvailableItemsOnly=true&MaxEntries=41&appid=$apikey",
		CURLOPT_USERAGENT => 'API sample cURL Request for sneakers',
	]);
	//send the request & save the response to $resp
	$resp = curl_exec($curl);

	//close request to clear up some resources
	curl_close($curl);
	
	return $resp;

/*
	$devices = array();

        $apiXML = simplexml_load_string($resp);	
	foreach ($apiXML -> Product as $item)
	{
        	$device = array();
        
		foreach ($item as $key => $value)
		{
			$device[(string) $key] = (string) $value;
        	}
		$devices[] = $device;
	}
	print_r($devices);
	$api_dataa = "";
	foreach ($devices as $item) 
	{	
		$price = "Price: $" . rand(40,120);

		if ($item['DisplayStockPhotos'] == "true")
		{
			$api_dataa .=  $item ['ProductID'] . "<br>";
			$api_dataa .= $item['DisplayStockPhotos']
				      . "<br>";		
			$api_dataa .=  $item ['Title'] . "<br>";
			$api_dataa .= $price . "<br>";
			$api_dataa .= "<img src = " . $item ['StockPhotoURL'] . 
					">" . "<br><br>";
			
		}
	}
	return $api_dataa;
*/
}

?>






























