
function google_ad_request_done(google_ads)
{
	
	/*
	* This function is required and is used to display
	* the ads that are returned from the JavaScript
	* request. You should modify the document.write
	* commands so that the HTML they write out fits
	* with your desired ad layout.
	*/
	var s = '';
	var i;
	
	/*
	* Verify that there are actually ads to display.
	*/
	if (google_ads.length == 0)
	{
		return;
	}
	
	if (google_ads[0].type == "flash")
	{
		s = '<div class="fullpostbit" align="center"><div class="ad_leaderboard" style="margin:0px"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"' +
		' codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="' + 
		google_ad.image_width + '" height="' + 
		google_ad.image_height + '"> <param name="movie" value="' + 
		google_ad.image_url + '" />' + 
		'<param name="quality" value="high" />' + 
		'<param name="allowscriptaccess" value="never" />' + 
		'<embed src="' + 
		google_ad.image_url + '" width="' + 
		google_ad.image_width + '" height="' + 
		google_ad.image_height + 
		'" type="application/x-shockwave-flash"' + 
		' allowscriptaccess="never" ' + 
		' pluginspage="http://www.macromedia.com/go/getflashplayer"></embed></object></div></div>';
	
	}
	else if (google_ads[0].type == "image")
	{
		s = '<div class="fullpostbit" align="center"><div class="ad_leaderboard" style="margin:0px"><a href="' + 
		google_ads[0].url + '" target="_top" title="go to ' + 
		google_ads[0].visible_url + '" onmouseout="window.status=\'\'" onmouseover="window.status=\'go to ' +
		google_ads[0].visible_url + '\';return true"><img border="0" src="' + 
		google_ads[0].image_url + '"width="' + 
		google_ads[0].image_width + '"height="' + 
		google_ads[0].image_height + '" /></a></div></div>';
	}
	else if (google_ads[0].type == "html")
	{
		s = '<div class="fullpostbit"><div class="ad_leaderboard" style="margin:0px">' + google_ads[0].snippet + '</div></div>';
	}
	else
	{
		s += ''; 
		
		/*
		* For text ads, append each ad to the string.
		*/
		
		for(i = 0; i < google_ads.length; ++i)
		{
			s += '<div class="minispaced"><div><span class="ad_line1"><a onmouseout="window.status=\'\'" onmouseover="window.status=\'go to ' + google_ads[i].visible_url + '\';return true" ' +
			'href="' + google_ads[i].url + '">' + google_ads[i].line1 + '</a></span></div>' +
			'<div><span class="ad_line2">' + google_ads[i].line2 + ' ' + google_ads[i].line3 + '</span> &nbsp;&nbsp;' +
			'<span class="ad_domain"><a onmouseout="window.status=\'\'" onmouseover="window.status=\'go to ' + google_ads[i].visible_url + '\';return true" ' +
			'href="' + google_ads[i].url + '">' + google_ads[i].visible_url + '</a></span></div></div>';
		}
		s = '<div class="fullpostbit"> <div class="postbit_message"> <div class="push_postbit"> <div class="cmspostbit_body" style="min-height:20px; margin-left:30px"> <div class="ad_google"><a href="' + google_info.feedback_url + '">Ads by Google</a></div>' + s + '			</div> </div> </div> <div class="post_userinfo"> &nbsp; </div> <div style="clear:both"></div> </div> '; 	
	}
	
	$('.adsense_postbit_skip').filter(':last').html(s);
	return;
}


google_ad_client = 'pub-8426641637123945'; // substitute your client_id (pub-#)
google_ad_channel = '4798191823+2728197858';
google_ad_output = 'js';
google_max_num_ads = '4';
google_ad_type = 'text_image';
google_image_size = '728x90';
google_feedback = 'on';
google_skip = '4'