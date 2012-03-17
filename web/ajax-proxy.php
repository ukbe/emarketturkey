<?php
/**
 * AJAX Cross Domain (PHP) Proxy 0.6
 *    by Iacovos Constantinou (http://www.iacons.net)
 * 
 * Released under CC-GNU GPL
 */

/**
 * Enables or disables filtering for cross domain requests.
 * Recommended value: true, for security reasons
 */
define('CSAJAX_FILTERS', true);


/**
 * A set of valid cross domain requests
 */
$valid_requests = array(
	'http://geek.emt/',
	'http://b2b.geek.emt/',
	'http://hr.geek.emt/',
	'http://tx.geek.emt/tr/default/boxtest',
	'http://ac.geek.emt/',
	'http://cm.geek.emt/',
);

/*** STOP EDITING HERE UNLESS YOU KNOW WHAT YOU ARE DOING ***/

// identify request headers
$request_headers = array();
foreach ( $_SERVER as $key=>$value ) {
	if( substr($key, 0, 5) == 'HTTP_' ) {
		$headername = str_replace('_', ' ', substr($key, 5));
		$headername = str_replace(' ', '-', ucwords(strtolower($headername)));
		$request_headers[$headername] = $value;
	}
}

// identify request method, url and params
$request_method = $_SERVER['REQUEST_METHOD'];
$request_params = ( $request_method == 'GET' ) ? $_GET : $_POST;
$request_url	= urldecode($request_params['csurl']);
$p_request_url	= parse_url($request_url);
unset($request_params['csurl']);

// ignore requests for proxy :)
if ( preg_match('!'. $_SERVER['SCRIPT_NAME'] .'!', $request_url) || empty($request_url) ) {
	exit;
}
	
// check against valid requests
if ( CSAJAX_FILTERS ) {
	$parsed 	= $p_request_url;
	$check_url  = isset($parsed['scheme']) ? $parsed['scheme'] .'://' : '';
	$check_url .= isset($parsed['user']) ? $parsed['user'] . ($parsed['pass'] ? ':'. $parsed['pass']:'') .'@' : '';
	$check_url .= isset($parsed['host']) ? $parsed['host'] : '';
	$check_url .= isset($parsed['port']) ? ':'.$parsed['port'] : '';
	$check_url .= isset($parsed['path']) ? $parsed['path'] : '';
	if ( !in_array($check_url, $valid_requests) ) {
		exit;
	}
}

// append query string for GET requests
if ( $request_method == 'GET' && count($request_params) > 0 && ( !array_key_exists('query', $p_request_url) || empty($p_request_url['query']) ) ) {
	$request_url .= '?'. http_build_query($request_params);
}

// let the request begin
$ch = curl_init($request_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);			// (re-)send headers
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);					// return response
curl_setopt($ch, CURLOPT_HEADER, true);							// enabled response headers
curl_setopt($ch, CURLOPT_, true);							// enabled response headers

// add post data for POST requests
if ( $request_method == 'POST' ) {
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request_params));
}

// retrieve response (headers and content)
$response = curl_exec($ch);
curl_close($ch);

// split response to header and content
list($response_headers, $response_content) = preg_split('/(\r\n){2}/', $response, 2);

// (re-)send the headers
$response_headers = preg_split('/(\r\n){1}/', $response_headers);
foreach ( $response_headers as $key => $response_header )
	if ( !preg_match('/^(Transfer-Encoding):/', $response_header) ) 
		header($response_header);

// finally, output the content
print($response_content);
?>