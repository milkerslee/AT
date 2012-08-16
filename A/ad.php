<?php
	function getWebHost() {
		$hostURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$hostURL .= "s";}
		$hostURL .= "://" . $_SERVER["SERVER_NAME"];
		if ($_SERVER["SERVER_PORT"] != "80")  {
			$hostURL .= ":" . $_SERVER["SERVER_PORT"];
		}
		return $hostURL;
	}

	function getBrowserFeature(){
		#TODO: ip, agent, plugin, language, ...

	}

	function getRealAd($url, $wpf, $bf, $uid){
		#TODO: compute real ad according to the users' browing history recorded.
		#TODO: refactoring the hardcode raUrl.
		$raUrl = getWebHost() . "/ra/dog.jpg"; 
		return $raUrl;
	}


	$ulr = $_GET['u'];
	$wpf = $_GET['wpf'];
	$ps = $_GET['ps'];
	$uid = $_SESSION['uid'];
	$bf = getBrowserFeature();

	$referer = $_SERVER['HTTP_REFERER'];
	list($protectorUrl) = explode("?", $referer);
	$raUrl = getRealAd($url, $wpf, $bf, $uid);
	$fullUrl = $protectorUrl . '?' . "ra=$raUrl&ps=$ps";

	header("Location:$fullUrl");
?>