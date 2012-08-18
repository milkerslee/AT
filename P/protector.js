$(function(){
		var pws = AT.pws
			, aws = AT.aws
			, wpf = AT.wpf

		$.getJSON(aws, {command: "GET_AD_ID", wpf: wpf}, function(ad){
			$.getJSON(pws, {command: "ACCUMULATE_IMPRESS", ra:ad.ra}, function(){
				$.getJSON(aws, {command: "GET_AD_CONTNET", ra:ad.ra}, function(content){
					$('body').append(content.html);
					$('body').click(function(event){
						// showDemension();
						$.getJSON(aws, {command: "GET_AD_TARGET", ra: ad.ra}, function(landingPage){
							$.getJSON(pws, {command: "ACCUMULATE_AD", l:landingPage.url}, function(contentPage){
								// telling Advertiser where users from via referer param. since the http header's referer field is shade by the protector.
								top.location.href = landingPage.url + '?referer=' + contentPage.url; 
							});
						});
					});
				});
			});
		});
	}
);