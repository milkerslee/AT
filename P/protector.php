<!DOCTYPE html>
<?php
	function getUrl($html){
		# TODO: extract URL.
		$pattern  = '#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#';
		preg_match($pattern, $html, $matches);
		return $matches[1];
	}

	function getWpf($url){
		# TODO: may retrieve wpf from some complex mining app.
		return 'NOT_IMPLEMENTED';
	}

	function explodeAtQuery($html){
		if(strpos($html, '?') === false) return array($html, '');
		return explode('?', $html);
	}

	function getNewQureyString($queryString, $wpf){
		if($queryString === '') return "wpf=$wpf";
		return "wpf=$wpf" . '&' . $queryString;
	}

	function addWpf($html, $wpf){
		$oldUrl = getUrl($html);
		list($fullPath, $queryString) = explodeAtQuery($oldUrl);
		$newQueryString = getNewQureyString($queryString, $wpf);
		$newUrl = implode('?', array($fullPath, $newQueryString));
		return str_replace($oldUrl, $newUrl, $html);
	}

	function makeAdIframe(){
		$oldHtml = $_GET['a'];
		$wpf = getWpf(getUrl($oldHtml));
		$newHtml = addWpf($oldHtml, $wpf);
		return $newHtml;
	}

	function accumlateImpress($contentUrl, $realAdUrl){
		#TODO
	}

?>

<?php if(!isset($_GET['ra'])) { ?>

<html>
<head>
	<script type="text/javascript" src="forward.js"></script>
	<style type="text/css">
		body {
			padding: 0px;
			margin: 0px;
			width: 0px;
		}
	</style>
</head>
<body>
	<?= makeAdIframe() ?>
</body>
</html>

<?php } else { 

$raUrl = $_GET['ra'];
echo "blalalalalal";
header("Location:$raUrl");

} ?>
