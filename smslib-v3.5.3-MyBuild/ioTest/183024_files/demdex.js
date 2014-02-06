//version:24
var Tim = {version:16, vid:"_VID_", partner:"ziffdavis", pid:1141, cid:205, dp_added:false, dp_enabled:true, tagList:[], bodyTags:{dom:[], load:[]}, tagCodes:{dom:[], load:[]}, bufStr:{dom:"", load:""}, counter:[], miscVar:[], aDiv:null, sDiv:null, nDiv:null, stagingPath:null, stagingFiles:null, stageAllFiles:false, isStaged:false, vars:{stuff:{}}, constants:{HEAD:1, BODY:2, ONLOAD:3, CURRENT_DATE:+new Date, isHTTPS:"https:" == document.location.protocol, isHTTP:"http:" == document.location.protocol, 
URL_NONSECURE:"cdn.demdex.net", URL_SECURE:"a248.e.akamai.net/demdex.download.akamai.com", XMLParser:{specialChars:/</, reverseChars:/&lt;/, scriptRegex:/<script[^>]*>([\s\S]*)<\/script>/}}, tags:{head:null, body:null, onload:null}, getProtoStr:function() {
  return Tim.constants.isHTTPS ? "https://" : "http://"
}, demdexSubmit:function(pixels) {
  var partner_ref = this;
  if(!pixels) {
    return false
  }
  pixels.data = Tim.helpers.convertObjectToKeyValuePairs(pixels.data || {}, "=", true);
  pixels.logdata = Tim.helpers.convertObjectToKeyValuePairs(pixels.logdata || {}, "=", true);
  pixels.logdata.push("containerid=" + partner_ref.cid);
  pixels.logdata.push("_cb=" + (new Date).getTime());
  partner_ref.pixels.waiting.push(partner_ref.destEventsFunctions.makePixelSrc(pixels));
  pixels.callback = typeof pixels.callback == "function" ? pixels.callback : function() {
  };
  partner_ref.pixels.callbacks.push(pixels.callback);
  delete pixels.callback;
  return partner_ref.waitingController.registerFire("firePixels")
}, demdexEvent:function(events, dontUseJSONP, callbackSuffix) {
  var partner_ref = this, e = partner_ref.destEvents, callback;
  if(!events) {
    return false
  }
  events.logdata = Tim.helpers.convertObjectToKeyValuePairs(events.logdata || {}, "=", true);
  events.logdata.push("containerid=" + partner_ref.cid);
  events.logdata.push("_ts=" + (new Date).getTime());
  if(e.useJSONP = !dontUseJSONP) {
    callback = e.callbackPrefix + (callbackSuffix ? callbackSuffix : (new Date).getTime());
    e.callbackNames.push(callback);
    e.callbacks.push(callback)
  }
  e.waiting.push({src:partner_ref.destEventsFunctions.makeDestEventSrc(events, e), useJSONP:e.useJSONP});
  partner_ref.waitingController.registerFire("fireDestEvent")
}, pixelEvent:function(events) {
  this.demdexEvent(events, true)
}, waitingController:{firingQueue:[], fired:[], firing:false, registerFire:function(firingType) {
  if(typeof firingType == "string" && (firingType == "firePixels" || firingType == "fireDestEvent")) {
    this.firingQueue.push(firingType)
  }
  if(!this.firing && this.firingQueue.length) {
    Tim.destEventsFunctions[this.firingQueue.shift()]()
  }
}}, pixels:{waiting:[], fired:[], callbacks:[], num_of_pixel_responses:0}, destEvents:{waiting:[], fired:[], errored:[], callbackNames:[], callbacks:[], callbackPrefix:"demdexDestCallback", useJSONP:false, num_of_jsonp_responses:0, num_of_jsonp_errors:0, num_of_img_responses:0, num_of_img_errors:0}, usesDestinations2:false, dest2IframeHasLoaded:false, dest2Iframe:null, dest2IframeSrc:"", dest2MessageQueue:[], dest2MessageQueueIsFiring:false, dest2ProcessMessageQueue:function() {
  if(!this.dest2IframeHasLoaded || this.dest2MessageQueueIsFiring) {
    return
  }
  this.dest2MessageQueueIsFiring = true;
  var INTERVAL = window["postMessage"] ? 15 : 100, self = this, interval = setInterval(function() {
    if(self.dest2MessageQueue.length) {
      Tim.xdProps.xd.postMessage(self.dest2MessageQueue.shift(), self.dest2IframeSrc, self.dest2Iframe.contentWindow)
    }else {
      clearInterval(interval);
      self.dest2MessageQueueIsFiring = false
    }
  }, INTERVAL)
}, destEventsFunctions:{makePixelSrc:function(p) {
  p.pdata = Tim.helpers.removeNaNs(p.pdata || []);
  var f = Tim.helpers.encodeAndBuildRequest, str = "", fp = p.pdata[0] ? p.pdata[0] : "", data = (p.data || []).join("&"), pdata = f(p.pdata.slice(1), "&"), extras = f(p.extras || [], "|"), logdata = (p.logdata || []).join("&"), proto_str = Tim.constants.isHTTPS ? "https://" : "http://";
  str = proto_str + Tim.partner + ".demdex.net/pixel/" + fp + "?" + (data.length ? "data:" + data + "|" : "") + (pdata.length ? "pdata:" + pdata + "|" : "") + (extras.length ? extras + "|" : "") + (logdata.length ? "logdata:" + logdata + "|" : "");
  return str.charAt(str.length - 1) === "|" ? str.substring(0, str.length - 1) : str
}, makeDestEventSrc:function(p, e) {
  p.pdata = Tim.helpers.removeNaNs(p.pdata || []);
  var f = Tim.helpers.encodeAndBuildRequest, pdata = f(p.pdata, "&d_px="), logdata = (p.logdata || []).join("&"), proto_str = Tim.constants.isHTTPS ? "https://" : "http://", others = function() {
    var a = [], key;
    for(key in p) {
      if(key != "pdata" && key != "logdata" && p.hasOwnProperty(key)) {
        try {
          var val = p[key] instanceof Array ? f(p[key], ",") : encodeURIComponent(p[key]);
          a.push(key + "=" + val)
        }catch(__TIM_Err__) {
        }
      }
    }
    return a.length ? "&" + a.join("&") : ""
  }();
  return(proto_str + Tim.partner + ".demdex.net/event?" + (pdata.length ? "d_px=" + pdata : "") + (logdata.length ? "&d_ld=" + encodeURIComponent(logdata) : "") + others + (e.useJSONP ? "&d_rtbd=json&d_dst=1&d_cts=1&d_cb=" + e.callbackNames.shift() : "")).replace(/\?&/, "?").replace(/\?$/, "")
}, firePixels:function() {
  var img = null, that = Tim, p = Tim.pixels, src;
  if(!p.waiting.length || Tim.waitingController.firing) {
    return false
  }
  Tim.waitingController.firing = true;
  img = new Image(0, 0);
  img.onload = img.onerror = img.onabort = function() {
    try {
      p.callbacks.shift()()
    }catch(__TIM_Err__) {
      if(typeof Tim != "undefined" && typeof Tim.error != "undefined" && typeof Tim.error.handleError == "function") {
        __TIM_Err__.filename = __TIM_Err__.filename || "demdex.js";
        Tim.error.handleError(__TIM_Err__)
      }else {
        (new Image(0, 0)).src = (document.location.protocol == "https:" ? "https://" : "http://") + "error.demdex.net/pixel/14137?logdata:Error handling not defined"
      }
    }
    that.waitingController.firing = false;
    p.num_of_pixel_responses++;
    that.waitingController.registerFire("firePixels")
  };
  src = p.waiting.shift();
  img.src = src;
  p.fired.push(src);
  Tim.waitingController.fired.push(src);
  return true
}, fireDestEvent:function() {
  var self = Tim, e = Tim.destEvents, first_script = null, script, img, imgAbortOrErrorHandler, current, src;
  if(!e.waiting.length || Tim.waitingController.firing) {
    return false
  }
  Tim.waitingController.firing = true;
  current = e.waiting.shift();
  src = current.src;
  if(!current.useJSONP) {
    img = new Image(0, 0);
    img.onload = function() {
      self.waitingController.firing = false;
      e.fired.push(src);
      self.waitingController.fired.push(src);
      e.num_of_img_responses++;
      self.waitingController.registerFire("fireDestEvent")
    };
    imgAbortOrErrorHandler = function(event) {
      var __TIM_Err__ = {filename:"demdex.js", message:event.detail};
      if(typeof Tim != "undefined" && typeof Tim.error != "undefined" && typeof Tim.error.handleError == "function") {
        Tim.error.handleError(__TIM_Err__)
      }else {
        (new Image(0, 0)).src = (document.location.protocol == "https:" ? "https://" : "http://") + "error.demdex.net/pixel/14137?logdata:Error handling not defined"
      }
      self.waitingController.firing = false;
      e.errored.push(src);
      e.num_of_img_errors++;
      self.waitingController.registerFire("fireDestEvent")
    };
    if(img.addEventListener) {
      img.addEventListener("error", imgAbortOrErrorHandler, false);
      img.addEventListener("abort", imgAbortOrErrorHandler, false)
    }else {
      if(img.attachEvent) {
        img.attachEvent("onerror", imgAbortOrErrorHandler, false);
        img.attachEvent("onabort", imgAbortOrErrorHandler, false)
      }
    }
    img.src = src
  }else {
    window[e.callbacks.shift()] = function(json) {
      var dests, f, i, l, dest, a, stuff, stf, cn, cv, ttl, dmn;
      try {
        if(json) {
          if((stuff = json.stuff) && stuff instanceof Array && (l = stuff.length)) {
            for(i = 0;i < l;i++) {
              if(stf = stuff[i]) {
                cn = stf.cn;
                cv = stf.cv;
                ttl = stf.ttl;
                dmn = stf.dmn || "." + document.domain;
                if(cn && (cv || cv == 0)) {
                  self.vars.stuff[cn] = cv;
                  if(ttl && !isNaN(parseInt(ttl, 10))) {
                    self.setCookie(cn, cv, ttl * 24 * 60, "/", dmn, false)
                  }
                }
              }
            }
          }
          if((dests = json.dests) && dests instanceof Array && (l = dests.length)) {
            f = encodeURIComponent;
            for(i = 0;i < l;i++) {
              dest = dests[i];
              a = [f(dest.id), f(dest.y), f(dest.c)];
              self.dest2MessageQueue.push(a.join("|"))
            }
            self.dest2ProcessMessageQueue()
          }
        }
        self.waitingController.firing = false;
        e.fired.push(src);
        self.waitingController.fired.push(src);
        e.num_of_jsonp_responses++;
        self.waitingController.registerFire("fireDestEvent")
      }catch(__TIM_Err__) {
        if(typeof Tim != "undefined" && typeof Tim.error != "undefined" && typeof Tim.error.handleError == "function") {
          __TIM_Err__.filename = __TIM_Err__.filename || "demdex.js";
          Tim.error.handleError(__TIM_Err__)
        }else {
          (new Image(0, 0)).src = (document.location.protocol == "https:" ? "https://" : "http://") + "error.demdex.net/pixel/14137?logdata:Error handling not defined"
        }
      }
    };
    script = document.createElement("script");
    if(script.addEventListener) {
      script.addEventListener("error", function(event) {
        var __TIM_Err__ = {filename:"demdex.js", message:event.detail};
        if(typeof Tim != "undefined" && typeof Tim.error != "undefined" && typeof Tim.error.handleError == "function") {
          Tim.error.handleError(__TIM_Err__)
        }else {
          (new Image(0, 0)).src = (document.location.protocol == "https:" ? "https://" : "http://") + "error.demdex.net/pixel/14137?logdata:Error handling not defined"
        }
        self.waitingController.firing = false;
        e.errored.push(src);
        e.num_of_jsonp_errors++;
        self.waitingController.registerFire("fireDestEvent")
      }, false)
    }
    script.type = "text/javascript";
    script.src = src;
    first_script = document.getElementsByTagName("script")[0];
    first_script.parentNode.insertBefore(script, first_script)
  }
}}, dp_makeUrl:function(partner) {
  var dpm_url = "", regex = /%%PARTNER%%/g;
  if(this.usesDestinations2) {
    if(Tim.constants.isHTTP) {
      dpm_url = "http://fast.%%PARTNER%%.demdex.net/dest2.html"
    }else {
      if(Tim.constants.isHTTPS) {
        dpm_url = "https://%%PARTNER%%.demdex.net/dest2.html"
      }
    }
  }else {
    if(Tim.constants.isHTTP) {
      dpm_url = "http://fast.%%PARTNER%%.demdex.net/DSD-gz/%%PARTNER%%-dest.html"
    }else {
      if(Tim.constants.isHTTPS) {
        dpm_url = "https://%%PARTNER%%.demdex.net/%%PARTNER%%-dest.html"
      }
    }
  }
  if(!dpm_url) {
    return false
  }
  return dpm_url.replace(regex, partner)
}, helpers:{concatNodeLists:function() {
  var theLists = [].slice.call(arguments), list = null, i = 0, element = null, finalList = [];
  if(!theLists.length) {
    return finalList
  }
  list = theLists.pop();
  do {
    for(i = 0;element = list[i++];) {
      finalList.push(element)
    }
  }while(list = theLists.pop());
  return finalList
}, indexOf:function(arr, value) {
  if(!Array.prototype.indexOf) {
    Tim.helpers.indexOf = function(arr, value) {
      for(var i = 0, l = arr.length;i < l;i++) {
        if(arr[i] === value) {
          return i
        }
      }
      return-1
    }
  }else {
    Tim.helpers.indexOf = function(arr, value) {
      return arr.indexOf(value)
    }
  }
  Tim.helpers.indexOf(arr, value)
}, convertObjectToKeyValuePairs:function(obj, separator, encode) {
  var arr = [], separator = separator || "=", key, value;
  for(key in obj) {
    value = obj[key];
    if(typeof value != "undefined" && value != null) {
      arr.push(key + separator + (encode ? encodeURIComponent(value) : value))
    }
  }
  return arr
}, isArray:function(a) {
  return"[object Array]" == Object.prototype.toString.apply(a)
}, map:function(arr, fun) {
  if(!Array.prototype.map) {
    if(arr === void 0 || arr === null) {
      throw new TypeError;
    }
    var t = Object(arr);
    var len = t.length >>> 0;
    if(typeof fun !== "function") {
      throw new TypeError;
    }
    var res = new Array(len);
    var thisp = arguments[1];
    for(var i = 0;i < len;i++) {
      if(i in t) {
        res[i] = fun.call(thisp, t[i], i, t)
      }
    }
    return res
  }else {
    return arr.map(fun)
  }
}, removeNaNs:function(as) {
  var i = 0, l = as.length, a, newAs = [];
  for(i = 0;i < l;i++) {
    a = as[i];
    if(typeof a != "undefined" && a != null && !isNaN(a = parseInt(a, 10))) {
      newAs.push(a)
    }
  }
  return newAs
}, encodeAndBuildRequest:function(arr, character) {
  return Tim.helpers.map(arr, function(c) {
    return encodeURIComponent(c)
  }).join(character)
}}, getTags:function(posvar) {
  var tagStr = "", tags = [], dest = "", exclusion = "", code = null, pos = null, expires = null, scope = null, rgxExcl = null, rgxDest = null, url = document.location.href;
  for(var i = 0;i < this.tagList.length;i++) {
    pos = this.tagList[i]["pos"];
    expires = this.tagList[i]["expires"];
    if(pos != posvar || expires != null && expires < this.constants.CURRENT_DATE) {
      continue
    }
    scope = this.tagList[i]["scope"];
    code = this.constants.isHTTPS ? this.tagList[i]["scode"] : this.tagList[i]["code"];
    dest = this.tagList[i]["dest"];
    if(scope == 1) {
      if(posvar == 1) {
        tagStr += code
      }else {
        tags[tags.length] = this.tagList[i]
      }
      continue
    }
    if(scope == 2) {
      exclusion = this.tagList[i]["exclusion"];
      rgxExcl = new RegExp(exclusion, "ig");
      if(url.indexOf(dest) >= 0 && (exclusion == null || exclusion == "" || !rgxExcl.test(url))) {
        if(posvar == 1) {
          tagStr += code
        }else {
          tags[tags.length] = this.tagList[i]
        }
      }
    }
    if(scope == 3) {
      if(document.location.href.toString() == dest.toString()) {
        if(posvar == 1) {
          tagStr += code
        }else {
          tags[tags.length] = this.tagList[i]
        }
      }
    }
    if(scope == 4) {
      try {
        rgxDest = new RegExp(dest, "i");
        exclusion = this.tagList[i]["exclusion"];
        rgxExcl = new RegExp(exclusion, "ig");
        if(rgxDest.test(url) && (exclusion == null || exclusion == "" || !rgxExcl.test(url))) {
          if(posvar == 1) {
            tagStr += code
          }else {
            tags[tags.length] = this.tagList[i]
          }
        }
      }catch(__TIM_Err__) {
        if(typeof Tim != "undefined" && typeof Tim.error != "undefined" && typeof Tim.error.handleError == "function") {
          __TIM_Err__.partner = Tim.partner || "no_partner";
          __TIM_Err__.filename = __TIM_Err__.filename || "demdex.js";
          Tim.error.handleError(__TIM_Err__)
        }else {
          (new Image(0, 0)).src = (document.location.protocol == "https:" ? "https://" : "http://") + "error.demdex.net/pixel/14137?logdata:Error handling not defined"
        }
      }
    }
  }
  return posvar == 1 ? tagStr : tags
}, getHeadTags:function() {
  return Tim.tags.head
}, getBodyTags:function() {
  return Tim.tags.body
}, getOnloadTags:function() {
  return Tim.tags.onload
}, checkLoaded:function(viter, type) {
  try {
    if(Tim.counter.length >= Tim.bodyTags[type].length || viter >= 10) {
      Tim.aDiv.innerHTML += Tim.bufStr[type];
      for(var i = 0;i < Tim.tagCodes[type].length;i++) {
        eval(Tim.tagCodes[type][i])
      }
    }else {
      viter++;
      setTimeout("Tim.checkLoaded(" + viter + ',"' + type + '")', 400)
    }
  }catch(__TIM_Err__) {
    if(typeof Tim != "undefined" && typeof Tim.error != "undefined" && typeof Tim.error.handleError == "function") {
      __TIM_Err__.partner = Tim.partner || "no_partner";
      __TIM_Err__.filename = __TIM_Err__.filename || "demdex.js";
      Tim.error.handleError(__TIM_Err__)
    }else {
      (new Image(0, 0)).src = (document.location.protocol == "https:" ? "https://" : "http://") + "error.demdex.net/pixel/14137?logdata:Error handling not defined"
    }
  }
}, domReady:function(tags, type) {
  var code = "";
  Tim.sDiv.appendChild(Tim.aDiv);
  Tim.sDiv.appendChild(Tim.nDiv);
  document.body.appendChild(Tim.sDiv);
  for(var i = 0;i < tags.length;i++) {
    code = Tim.constants.isHTTPS ? tags[i].scode : tags[i].code;
    if(code.toLowerCase().indexOf("iframe") != -1) {
      var str = code.replace(/&/g, "&amp;");
      var xmlDoc;
      if(document.implementation.createDocument) {
        var parser = new DOMParser;
        xmlDoc = parser.parseFromString(str, "text/xml")
      }else {
        if(window.ActiveXObject) {
          xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
          xmlDoc.async = "false";
          xmlDoc.loadXML(str)
        }
      }
      var m = Tim.helpers.concatNodeLists(xmlDoc.getElementsByTagName("IFRAME"), xmlDoc.getElementsByTagName("iframe"));
      if(m.length != 0) {
        var src;
        if(m[0].getAttribute("src")) {
          src = m[0].getAttribute("src")
        }else {
          if(m[i].getAttribute("SRC")) {
            src = m[0].getAttribute("SRC")
          }
        }
        var iframe = document.createElement("IFRAME");
        iframe.setAttribute("style", "display:none");
        iframe.setAttribute("width", "0");
        iframe.setAttribute("height", "0");
        iframe.setAttribute("id", "ddiframe");
        iframe.setAttribute("src", src);
        document.body.appendChild(iframe)
      }
    }else {
      if(code.toLowerCase().indexOf("<\/script") != -1) {
        Tim.reparse(code.replace(/&/g, "&amp;"), type)
      }else {
        Tim.nDiv.innerHTML += code
      }
    }
  }
  var loaded = false, tsrcFile = null;
  for(var j = 0;j < Tim.bodyTags[type].length;j++) {
    var tsrc = false;
    var tbody = "";
    if(typeof Tim.bodyTags[type][j] != "undefined") {
      tsrc = Tim.bodyTags[type][j].src;
      tbody = Tim.bodyTags[type][j].body
    }
    if(tsrc) {
      if(Tim.stagingPath) {
        tsrcFile = tsrc.split("/").pop();
        if(Tim.stageAllFiles || Tim.stagingFiles.indexOf(tsrcFile) > -1) {
          tsrc = Tim.stagingPath + tsrcFile;
          Tim.isStaged = true
        }
      }
      var script = document.createElement("script");
      script.setAttribute("type", "text/javascript");
      script.setAttribute("src", tsrc);
      script.onload = script.onreadystatechange = function() {
        Tim.counter[Tim.counter.length] = 1
      };
      Tim.sDiv.appendChild(script)
    }else {
      Tim.counter[Tim.counter.length] = 1
    }
    Tim.bufStr[type] += "<br/>" + "<SCR" + 'IPT type="text/javascript">' + tbody + "</" + "SCRIPT>";
    Tim.tagCodes[type][Tim.tagCodes[type].length] = tbody
  }
  setTimeout('Tim.checkLoaded(1, "' + type + '")', 500)
}, windowReady:function() {
  var self = this, iframe, src, proto_url, url, params = "", fld, fireDestEvents;
  if(!Tim.dp_added && Tim.partner) {
    for(var i = 0;i < Tim.miscVar.length;i++) {
      fld = Tim.constants.isHTTP ? "miscVarTagCode" : "miscVarSecureTagCode";
      params = params + Tim.miscVar[i][fld] + "&";
      if(this.miscVar[i][fld] == "timevents=2") {
        this.usesDestinations2 = true
      }
    }
    iframe = document.createElement("iframe");
    url = Tim.dp_makeUrl(Tim.partner);
    if(!url) {
      return
    }
    if(params) {
      url += "?" + params.replace(/&$/, "")
    }
    if(this.usesDestinations2) {
      url += "#" + encodeURIComponent(document.location.href)
    }
    iframe.style.cssText = "display:none;width:0px;height:0px;";
    iframe.width = 0;
    iframe.height = 0;
    iframe.id = "dpiframe";
    iframe.src = url;
    if(this.usesDestinations2) {
      this.dest2Iframe = iframe;
      this.dest2IframeSrc = url;
      fireDestEvents = function() {
        self.dest2IframeHasLoaded = true;
        self.dest2ProcessMessageQueue()
      };
      if(iframe.addEventListener) {
        iframe.addEventListener("load", fireDestEvents, false)
      }else {
        if(iframe.attachEvent) {
          iframe.attachEvent("onload", fireDestEvents)
        }
      }
    }
    Tim.dp_added = !!document.body.appendChild(iframe)
  }
}, getText:function(node) {
  var buffer = "";
  var cnodes = node.childNodes;
  if(cnodes) {
    for(var i = 0;i < cnodes.length;i++) {
      buffer = buffer + this.getText(cnodes[i])
    }
  }
  if(node.data) {
    buffer += node.data
  }
  return buffer
}, xmlSpecialCharsParser:function() {
  function parse(text) {
    var div = document.createElement("div");
    div.innerHTML = "<br />" + text;
    return div.getElementsByTagName("script")
  }
  function santize(scripts) {
    var i = 0, st = "", script = null, tcx = Tim.constants.XMLParser;
    for(i = 0;script = scripts[i++];) {
      st = script.text;
      script.customText = tcx.specialChars.test(st) ? st.replace(tcx.specialChars, "&lt;") : st
    }
    return scripts
  }
  function combine(scripts) {
    var i = 0, script = null, src = "", buffer = "";
    for(i = 0;script = scripts[i++];) {
      src = script.src || script.SRC;
      buffer += src ? '<script type="text/javascript" src="' + src + '"><\/script>' : '<script type="text/javascript">' + script.customText + "<\/script>"
    }
    return buffer
  }
  return function(text) {
    var tcx = Tim.constants.XMLParser, contents = tcx.scriptRegex.exec(text);
    return contents && tcx.specialChars.test(contents[1]) ? combine(santize(parse(text))) : text
  }
}(), reparse:function(parm, type) {
  var tagscript = {};
  parm = Tim.xmlSpecialCharsParser(parm);
  var str = "<div>" + parm + "</div>";
  var strBuf = "";
  var docStr = "";
  var xDoc = null;
  document._originalWrite = document.write;
  document.write = function(t) {
    docStr += t
  };
  var xmlDoc;
  if(document.implementation.createDocument) {
    var parser = new DOMParser;
    xmlDoc = parser.parseFromString(str, "text/xml")
  }else {
    if(window.ActiveXObject) {
      xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
      xmlDoc.async = "false";
      xmlDoc.loadXML(str)
    }
  }
  var m = Tim.helpers.concatNodeLists(xmlDoc.getElementsByTagName("SCRIPT"), xmlDoc.getElementsByTagName("script"));
  for(var i = 0;i < m.length;i++) {
    if(m[i].getAttribute("src")) {
      tagscript["src"] = m[i].getAttribute("src")
    }else {
      if(m[i].getAttribute("SRC")) {
        tagscript["src"] = m[i].getAttribute("SRC")
      }
    }
    var tagbody = Tim.getText(m[i]);
    tagbody = tagbody.replace(Tim.constants.XMLParser.reverseChars, "<");
    if(tagbody.indexOf("document.write") == -1) {
      if(tagscript["body"]) {
        tagscript["body"] = tagscript["body"] + tagbody
      }else {
        tagscript["body"] = tagbody
      }
    }else {
      eval(tagbody);
      if(document.implementation.createDocument) {
        xDoc = parser.parseFromString("<div>" + docStr + "</div>", "text/xml")
      }else {
        if(window.ActiveXObject) {
          xDoc = new ActiveXObject("Microsoft.XMLDOM");
          xDoc.async = "false";
          xDoc.loadXML("<div>" + docStr + "</div>")
        }
      }
      var n = Tim.helpers.concatNodeLists(xDoc.getElementsByTagName("SCRIPT"), xDoc.getElementsByTagName("script"));
      for(var j = 0;j < n.length;j++) {
        var ts = n[j].getAttribute("src");
        var tb = Tim.getText(n[j]);
        tagscript["src"] = ts;
        if(tagscript["body"]) {
          tagscript["body"] = tagscript["body"] + tb
        }else {
          tagscript["body"] = tb
        }
      }
    }
    docStr = ""
  }
  Tim.bodyTags[type][Tim.bodyTags[type].length] = tagscript;
  document.write = document._originalWrite;
  return strBuf
}, getCookie:function(name) {
  var dc = document.cookie, cname = name + "=", end = 0, begin = 0;
  if(dc.length > 0) {
    begin = dc.indexOf(cname);
    if(begin != -1) {
      begin += cname.length;
      end = dc.indexOf(";", begin);
      if(end == -1) {
        return unescape(dc.substring(begin))
      }else {
        return unescape(dc.substring(begin, end))
      }
    }
  }
  return null
}, setCookie:function(name, value, expires, path, domain, secure) {
  var today = new Date;
  if(expires) {
    expires = expires * 1E3 * 60
  }
  document.cookie = name + "=" + value + (expires ? ";expires=" + (new Date(today.getTime() + expires)).toGMTString() : "") + (path ? ";path=" + path : "") + (domain ? ";domain=" + domain : "") + (secure ? ";secure" : "")
}, events:{domready:{isDOMReady:false, isDOMEventBound:false}, onload:{isOnloadEventBound:false}, attachEvent:function(type) {
  var response = false;
  switch(type) {
    case "dom":
      response = !!Tim.tags.body.length;
      break;
    case "load":
      response = Tim.events.domready.isDOMEventBound || !!Tim.tags.onload.length || Tim.dp_enabled;
      break;
    default:
      break
  }
  return response
}, fireDomEvent:function() {
  if(!Tim.tags.body.length || Tim.events.domready.isDOMReady) {
    return
  }
  if(!document.body) {
    return setTimeout(Tim.events.fireDomEvent, 13)
  }
  Tim.events.domready.isDOMReady = true;
  Tim.domReady(Tim.getBodyTags(), "dom");
  if("removeEventListener" in document && Tim.events.domready.isDOMEventBound) {
    document.removeEventListener("DOMContentLoaded", Tim.events.fireDomEvent, false)
  }else {
    if("detachEvent" in document && Tim.events.domready.isDOMEventBound && document.readyState == "complete") {
      document.detachEvent("onreadystatechange", Tim.events.fireDomEvent)
    }
  }
  Tim.events.domready.isDOMEventBound = false
}, fireLoadEvent:function() {
  Tim.events.domready.isDOMEventBound && Tim.events.fireDomEvent();
  Tim.tags.onload.length && Tim.domReady(Tim.getOnloadTags(), "load");
  Tim.windowReady()
}, bindEvents:function() {
  if(Tim.events.domready.isDOMEventBound || Tim.events.onload.isOnloadEventBound) {
    return
  }
  if(document.readyState == "complete") {
    return setTimeout(function() {
      Tim.events.fireDomEvent();
      Tim.events.fireLoadEvent()
    }, 13)
  }
  if("addEventListener" in document) {
    if(Tim.events.attachEvent("dom")) {
      Tim.events.domready.isDOMEventBound = true;
      document.addEventListener("DOMContentLoaded", Tim.events.fireDomEvent, false)
    }
    if(Tim.events.attachEvent("load")) {
      Tim.events.onload.isOnloadEventBound = true;
      window.addEventListener("load", Tim.events.fireLoadEvent, false)
    }
  }else {
    if("attachEvent" in document) {
      var toplevel = false;
      if(Tim.events.attachEvent("dom")) {
        Tim.events.domready.isDOMEventBound = true;
        document.attachEvent("onreadystatechange", Tim.events.fireDomEvent)
      }
      if(Tim.events.attachEvent("load")) {
        Tim.events.onload.isOnloadEventBound = true;
        window.attachEvent("onload", Tim.events.fireLoadEvent)
      }
      try {
        toplevel = window.frameElement = null
      }catch(e) {
      }
      if(document.documentElement.doScroll && toplevel) {
        Tim.doScrollCheck()
      }
    }else {
      var oldOnload = window.onload || function() {
      };
      if(Tim.events.attachEvent("load")) {
        Tim.events.onload.isOnloadEventBound = true;
        window.onload = function(e) {
          oldOnload(e);
          window[Tim.domReady](e)
        }
      }
    }
  }
}, doScrollCheck:function() {
  if(Tim.events.domready.isDOMReady) {
    return
  }
  try {
    document.documentElement.doScroll("left")
  }catch(error) {
    setTimeout(Tim.doScrollCheck, 13);
    return
  }
  Tim.events.fireDomEvent()
}}, main:function(mv, tl) {
  if(mv && mv.length) {
    Tim.miscVar = Tim.miscVar.concat(mv)
  }
  if(tl && tl.length) {
    Tim.tagList = Tim.tagList.concat(tl)
  }
  if(this.magicCookie()) {
    return
  }
  Tim.tags.head = Tim.getTags(Tim.constants.HEAD);
  Tim.tags.body = Tim.getTags(Tim.constants.BODY);
  Tim.tags.onload = Tim.getTags(Tim.constants.ONLOAD);
  if(Tim.tags.head) {
    document.write(Tim.tags.head)
  }
  Tim.aDiv = document.createElement("div");
  Tim.aDiv.style.display = "none";
  Tim.sDiv = document.createElement("div");
  Tim.sDiv.style.display = "none";
  Tim.nDiv = document.createElement("div");
  Tim.nDiv.style.display = "none";
  Tim.aDiv.innerHTML = "";
  Tim.events.bindEvents()
}};
typeof Tim != "undefined" && (Tim.error = function() {
  var config = {pixelMap:{harvestererror:14138, destpuberror:14139, dpmerror:14140, generalerror:14137, error:14137, noerrortypedefined:15021, evalerror:15016, rangeerror:15017, referenceerror:15018, typeerror:15019, urierror:15020}, domain:"error.demdex.net/pixel/"}, src = "";
  function getRequest() {
    return src
  }
  function firePixel(src) {
    (new Image(0, 0)).src = (document.location.protocol == "https:" ? "https://" : "http://") + config.domain + src
  }
  function handleError(args) {
    var pixel = 0, name = args.name ? String(args.name).toLowerCase() : false, filename = args.filename ? String(args.filename) : false, partner = args.partner ? String(args.partner) : typeof Tim != undefined && Tim.partner ? String(Tim.partner) : "no_partner", site = args.site ? args.site : document.location.href, filename = args.filename ? String(args.filename) : false, message = args.message ? String(args.message) : false;
    pixel = name in config.pixelMap ? config.pixelMap[name] : config.pixelMap.noerrortypedefined;
    src = pixel + "?logdata:" + (message ? "message=" + message.replace(",", " ") + "," : "") + (site ? "site=" + site.replace(",", " ") + "," : "") + (partner ? "partner=" + partner.replace(",", " ") + "," : "") + (filename ? "filename=" + filename + "," : "");
    src = src.replace(/,$/, "");
    firePixel(src)
  }
  return{handleError:handleError, pixelMap:config.pixelMap, getErrorRequest:getRequest}
}());
typeof Tim != "undefined" && (Tim.magicCookie = function(testCookie) {
  var ck = testCookie || this.getCookie("demdex-staging"), src = null, script = null, script0 = null, ckArray = [], STAGING_SCRIPT_ID = "demdex_staging_replacement_script";
  if(ck) {
    ckArray = ck.split("|");
    this.stagingPath = ckArray[document.location.protocol == "https:" ? 1 : 2];
    this.stagingFiles = ckArray[3] || "";
    if(!this.stagingFiles) {
      this.stageAllFiles = true
    }
    if(!this.stagingPath || this.stagingFiles && this.stagingFiles.indexOf("demdex.js") < 0) {
      return false
    }
    this.isStaged = true;
    if(!document.getElementById(STAGING_SCRIPT_ID)) {
      src = this.stagingPath + "demdex.js";
      if(parseInt(ckArray[0], 10)) {
        script = document.createElement("script");
        script.type = "text/javascript";
        script.src = src;
        script.id = STAGING_SCRIPT_ID;
        script0 = document.getElementsByTagName("script")[0];
        script0.parentNode.insertBefore(script, script0)
      }else {
        document.write("<scr" + 'ipt type="text/javascript" id="' + STAGING_SCRIPT_ID + '" src ="' + src + '"></scr' + "ipt>")
      }
      return true
    }
  }
  return false
});
typeof Tim != "undefined" && (Tim.getSearchReferrer = function(arg) {
  var arg = arg || {}, site = arg.site ? arg.site : document.referrer, extensions = arg.extensions ? arg.extensions : false, aElement = function(ref) {
    var a = document.createElement("a");
    a.href = ("" + ref).toLowerCase();
    return a
  }(site), searchEngines = {"bing.":{name:"bing.com", pagePattern:/.*/, keywordPattern:/[&\?]q=([^&]+)/}, "google.":{name:"google.com", pagePattern:/.*/, keywordPattern:/[&\?]q=([^&]+)/}, "yahoo.":{name:"yahoo.com", pagePattern:/.*/, keywordPattern:/[&\?]p=([^&]+)/}, "ask.":{name:"ask.com", pagePattern:/.*/, keywordPattern:/[&\?]q=([^&]+)/}, "aol.":{name:"aol.com", pagePattern:/.*/, keywordPattern:/[&\?]q=([^&]+)/}}, re = [], keywordPattern = null, pagePattern = null, se = null, new_site = "", domain = 
  null, es = null, host = "", keywords = "", customSite = null, valid = null, se_regex = null, searchEngine = null;
  function santizeRE(str) {
    return str.replace(/\./g, "\\.")
  }
  function sanitizeURL(site) {
    site = site.split(".");
    return(site[0] == "www" ? site[1] : site[0]) + "."
  }
  function parseKeywords() {
    var query = null, pageTest = null, keywordMatch = null, retVal = "";
    query = "search" in aElement ? aElement.search : "";
    if(!query) {
      return retVal
    }
    pageTest = searchEngine.pagePattern.test(aElement.pathname);
    if(Tim.helpers.isArray(searchEngine.keywordPattern)) {
      for(var i = 0;!keywordMatch && i < searchEngine.keywordPattern.length;i++) {
        keywordMatch = query.match(searchEngine.keywordPattern[i])
      }
    }else {
      keywordMatch = query.match(searchEngine.keywordPattern)
    }
    return!!(pageTest && keywordMatch) ? decodeURIComponent(keywordMatch[1]).replace(/\+/g, " ") : ""
  }
  function parseDomain() {
    return searchEngine.name
  }
  function makeKeywordRegex(word) {
    return RegExp("[&?]" + santizeRE(word) + "=([^&]+)", "i")
  }
  if(extensions) {
    es = extensions.sites;
    for(customSite in es) {
      if(!es.hasOwnProperty(customSite)) {
        continue
      }
      new_site = es[customSite].match_all_extensions ? sanitizeURL(new_site) : customSite;
      pagePattern = es[customSite].search_page ? es[customSite].search_page : ".*";
      keywordPattern = es[customSite].search_param ? es[customSite].search_param : "q=";
      keywordPattern = Tim.helpers.isArray(keywordPattern) ? Tim.helpers.map(keywordPattern, makeKeywordRegex) : makeKeywordRegex(keywordPattern);
      searchEngines[new_site] = {name:customSite, pagePattern:RegExp(santizeRE(pagePattern)), keywordPattern:keywordPattern, matchExtensions:!!es[customSite].match_all_extensions}
    }
  }
  for(se in searchEngines) {
    searchEngines.hasOwnProperty(se) && re.push(se)
  }
  se_regex = RegExp(santizeRE(re.join("|")) + ".*?");
  domain = "hostname" in aElement ? aElement.hostname.match(se_regex) : "";
  searchEngine = domain in searchEngines ? searchEngines[domain] : "";
  valid = !!(domain && "search" in aElement && searchEngine);
  return{name:valid ? parseDomain() : "", keywords:valid ? parseKeywords() : "", valid:valid}
});
typeof Tim != "undefined" && (Tim.xdProps = {xd:function() {
  var interval_id, last_hash, cache_bust = 1, attached_callback;
  return{postMessage:function(message, target_url, target) {
    if(!target_url) {
      return
    }
    target = target || parent;
    if(window["postMessage"]) {
      target["postMessage"](message, target_url.replace(/([^:]+:\/\/[^\/]+).*/, "$1"))
    }else {
      if(target_url) {
        target.location = target_url.replace(/#.*$/, "") + "#" + +new Date + cache_bust++ + "&" + message
      }
    }
  }, receiveMessage:function(callback, source_origin) {
    if(window["postMessage"]) {
      if(callback) {
        attached_callback = function(e) {
          if(typeof source_origin === "string" && e.origin !== source_origin || Object.prototype.toString.call(source_origin) === "[object Function]" && source_origin(e.origin) === !1) {
            return!1
          }
          callback(e)
        }
      }
      if(window["addEventListener"]) {
        window[callback ? "addEventListener" : "removeEventListener"]("message", attached_callback, !1)
      }else {
        window[callback ? "attachEvent" : "detachEvent"]("onmessage", attached_callback)
      }
    }else {
      interval_id && clearInterval(interval_id);
      interval_id = null;
      if(callback) {
        interval_id = setInterval(function() {
          var hash = document.location.hash, re = /^#?\d+&/;
          if(hash !== last_hash && re.test(hash)) {
            last_hash = hash;
            callback({data:hash.replace(re, "")})
          }
        }, 100)
      }
    }
  }}
}()});
try {
  Tim.main([{'miscVarTagCode':'is_mediamath=1&mmvalidttl=10080', 'miscVarSecureTagCode':'is_mediamath=1&mmvalidttl=10080', 'miscVarTagType':1}],
[{ 'scope':1, 'pos':2, 'dest':'All available destinations', 'code': '<scr'+'ipt type=\"text/javascript\">\nvar dexBaseURL=((\"https:\"==document.location.protocol)? \"https://a248.e.akamai.net/demdex.download.akamai.com/ziffdavis/\": \"http://akcdn.demdex.net/ziffdavis/\");\ndocument.write(unescape(\"%3Cscript src=\'\"+ dexBaseURL + \"zdgeneric_noarts_v1.js\' type=\'text/javascript\' %3E%3C/script%3E\"));\n</script>', 'scode':'', 'expires':null, 'exclusion':''}])
}catch(__TIM_Err__) {
  if(typeof Tim != "undefined" && typeof Tim.error != "undefined" && typeof Tim.error.handleError == "function") {
    __TIM_Err__.filename = __TIM_Err__.filename || "demdex.js";
    Tim.error.handleError(__TIM_Err__)
  }else {
    (new Image(0, 0)).src = (document.location.protocol == "https:" ? "https://" : "http://") + "error.demdex.net/pixel/14137?logdata:Error handling not defined"
  }
}