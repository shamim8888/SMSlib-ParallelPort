//vBuletin AJAX Cron copyright 2006 by Code Monkey @ vBmodder.com aka JumpD
//You may not copy, re-release, modify or give away this code.
//You must purchase a subscription at http://vbmodder.com to recieve
//support.
function vB_AJAX_Cron_Init(_link, _rand){
	if(AJAX_Compatible){
		new vB_AJAX_Cron(_link, _rand);
	}
}

function vB_AJAX_Cron(_link, _rand){
	this.browser_url = location.hostname;
	this.link_obj = _link;
	this.rand_obj = _rand;
	this.xml_sender = null;

	this.checkDomainSecuruty = function (){
		var needs_www = (this.link_obj.indexOf('//www.')==-1)? false:true;
		var has_www = (this.browser_url.indexOf('www.')==-1)? false:true;
		if(needs_www && !has_www){
			this.link_obj = this.link_obj.replace('http://www.','http://');
		}else if(!needs_www && has_www){
			this.link_obj = this.link_obj.replace('http://','http://www.');
		}
	}

	this.cron_update = function(){
		if (!this.xml_sender){
			this.xml_sender = new vB_AJAX_Handler(true);
		}
		this.checkDomainSecuruty();
		this.xml_sender.onreadystatechange(this.onreadystatechange);
		this.xml_sender.send(
			this.link_obj+'?rand='+this.rand_obj,
			'rand='+this.rand_obj
		);
	}

	var me = this;

	this.onreadystatechange = function(){
		if (me.xml_sender.handler.readyState == 4 && me.xml_sender.handler.status == 200 && me.xml_sender.handler.responseText){
			if (is_ie){
				me.xml_sender.handler.abort();
			}
		}
	}
	this.cron_update();
}