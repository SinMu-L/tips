<?php
/**
 * 返回一个数组
 * ["content" => response body,
 * "error" => error info,
 * "responseCode" => 200]
 * @return array
 * @param string $url   请求的url
 * @param string $body  请求的body，可以是二进制也可以是json
 * @param string $method    请求方法，默认为 GET
 * @param array $headers    请求headers，期待是一个键值对数组
 * @param bool $certPath    请求证书，默认不使用证书
 */
function request( $url, $body = "", $method = "GET", $headers = [], $certPath = false )
{
	$options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_INFILESIZE => -1,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_CUSTOMREQUEST => $method,
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HEADER => true,
    ];

	if( $body != "" ) {
		$options[CURLOPT_POSTFIELDS] = $body;
	}
	if( $method === "POST" ) {
		$options[CURLOPT_POST] = true;
	} else if(  $method !== "GET" ) {
		$options[ CURLOPT_CUSTOMREQUEST ] = $method;
	}

    if ( count($headers) )
    {
    	$dataHeaders = [];
		foreach ($headers as $key => $value)
	        $dataHeaders[] = $key . ': ' . $value;

    	$options[ CURLOPT_HTTPHEADER ] = $dataHeaders;
    }

    if ( $certPath )
    	$options[CURLOPT_CAINFO] = $certPath;

    $result = [];
    $result["error"] = false;
    $result["content"] = null;

	try
	{
	    if (!$curl = curl_init())
	        throw new Exception('Unable to initialize cURL');

	    if (!curl_setopt_array($curl, $options))
	        throw new Exception(curl_error($curl));

		$response = curl_exec($curl);
		if(  $response === false ) 
			throw new Exception( curl_error($curl) );
		
		$result["responseCode"] = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
		$headerSize = curl_getinfo( $curl, CURLINFO_HEADER_SIZE );
		$result["content"] = substr( $response, $headerSize );

		if( !$result["content"] )
			$result["content"] = "";

		$result["header"] = substr( $response, 0, $headerSize );

	   	curl_close($curl);
    }
    catch ( Exception $e )
    {
 	   	$result["error"] = "CURL error: " . $e->getMessage();
	}

	return $result;
}
