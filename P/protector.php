<?php
	function hasQueryString($url){
		return stripos($url, '?');
	}

	function plusJSONP($url){
		if(hasQueryString($url)) return $url . '&callback=?';
		return $url . '?callback=?'; 
	}

	function getAdvertisingNetworkUrl(){
		return $_REQUEST['a']; 
	}

	function getProtectorUrl(){
		return 'http://protector.com/protector.php';
	}

	function getWPF($url){
		// TODO: May use any web mining tech. here.
		return 'NOT_IMPLEMENTED';
	}

	function accumlateImpress($advertising, $contentURL){
		# TODO: count and persit impress of advertising for billing.
	}

	function accumulateClick($landingPageURL, $contentURL){
		# TODO: count and persit click of advertising for billing.
	}

	function handleJSONP(){
		$command = $_REQUEST['command'];
		$contentURL = $_SESSION['contentURL'];

		if($command === 'ACCUMULATE_IMPRESS'){
			$advertising = $_REQUEST['ra'];
			accumlateImpress($advertising, $contentURL);
			$data = json_encode(null);
		}elseif ($command === 'ACCUMULATE_AD') {
			$landingPageURL = $_REQUEST['l'];
			accumulateClick($landingPageURL, $contentURL);
			$data = json_encode(array('url' => urlencode($contentURL)));
		}

		$jsonpCallback = $_REQUEST['callback'];
		echo "$jsonpCallback({$data})";
	}

	function storeContentURL(){
		$contentURL = $_SERVER['HTTP_REFERER'];
		$_SESSION['contentURL'] = $contentURL;
	}

	session_start();
	if(isset($_REQUEST['command'])) {
		handleJSONP();
	}else{
		storeContentURL();
?>
<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="jquery-1.7.js"></script>
	<script type="text/javascript" src="protector.js"></script>
	<script type="text/javascript">
		var AT = {
			pws : '<?= plusJSONP(getProtectorUrl()) ?>', // Protector's web service
			aws : '<?= plusJSONP(getAdvertisingNetworkUrl()) ?>', // Advertsing Network's web service
			wpf : '<?= getWPF($_SESSION['contentURL']) ?>', // Web Page Feature of Container Content Page
		}
		function showDemension(){alert('Height: ' + document.body.scrollHeight + '\nWidth: '  + document.body.scrollWidth);}
	</script>
</head>
<body style='margin:0px; padding:0px;'>
</body>
</html>		
<?php } ?>