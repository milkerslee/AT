<?php
	function computeRealAdvertisingId($wpf, $uid, $bf){
		# TODO: any complex algorithm may be used by Advertising Networks, insteading of our dumb method here. 
		return 'ra/dog.jpg';
	}


	function getUidFromCookie(){
		if(isset($_COOKIE['uid'])){
			$uid = $_COOKIE['uid'];
		}else{
			$A_MONTH_LATE = time() + 60 * 60 * 24 * 7 * 30;
			$uid = generateUid();
			setcookie('uid', $uid , $A_MONTH_LATE);
		}
		return $uid;
	}

	function generateUid(){
		return 'uid-' . time() . rand();
	}

	function getBrowserFeatures(){
		# TODO: any complex algorithm may be used by Advertising Network to Retrieve useful browser features for computing user profile.
		return 'NOT_IMPLEMENTED';
	}

	function updateUserProfile($uid, $delta){
		# TODO: any complex algorithm may be used by Advertising Network to mine user profile.
		return 'NOT_IMPLEMENTED';
	}

	function getAdvertisingHTMLById($raId){
		# just a dumb implemetation
		return "<img src='http://advertising.com/$raId' />";
	}

	function getAdvertiserUrl($raId){
		# just a dumb implemetation
		return 'http://advertiser.com/landing.html';
	}

	$command = $_REQUEST['command'];
	if($command === 'GET_AD_ID'){
		$wpf = $_REQUEST['wpf'];
		$uid = getUidFromCookie();
		$bf = getBrowserFeatures();
		# TODO: compute real ad according to wpf
		$data = json_encode(array('ra' => computeRealAdvertisingId($wpf, $uid, $bf)));
		updateUserProfile($uid,array('wpf' => $wpf));
	}elseif($command === 'GET_AD_CONTNET') {
		$raId = $_REQUEST['ra'];
		$data = json_encode(array('html' => getAdvertisingHTMLById($raId)));
	}elseif($command === 'GET_AD_TARGET') {
		$raId = $_REQUEST['ra'];
		$data = json_encode(array('url' => getAdvertiserUrl($raId)));
	}

	$jsonpCallback = $_REQUEST['callback'];
	echo "$jsonpCallback($data)";
?>