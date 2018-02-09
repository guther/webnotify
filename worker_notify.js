self.addEventListener('message', function(e) {
  var data = e.data;
  switch (data.cmd) {
    case 'start':
      fnc_init_check_notify(data.notification_id);
      break;
    case 'set_time_start':
      setTimeout(function(){fnc_init_check_notify(data.notification_id);},5000);
      break;
    case 'stop':
      self.close(); // Encerra o worker
      break;
  };
}, false);

function fnc_is_json_string(str){
    try {
        JSON.parse(str);
    }
    catch (e) {
        return false;
    }
    return true;
}

function fnc_init_check_notify(notification_id){
	
	var param = typeof(notification_id)=="number"?notification_id:0;
	
	var ajaxurl = 'notificacoes.php?id='+param;
	var xmlHttp = ajax();
	if(xmlHttp){
		xmlHttp.onreadystatechange=function(){
   			if(xmlHttp.readyState==4){
				var json = xmlHttp.responseText;
				if(fnc_is_json_string(json))
					self.postMessage({'cmd':'json','json':json});
				else
					self.postMessage({'cmd':'re_check'});
			}
		};
		xmlHttp.open("get",ajaxurl,true);
		xmlHttp.send(null);
	}
}

function ajax() {
    var xmlHttp;
    try {
        xmlHttp = new XMLHttpRequest();
    } catch (e) {
        try {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                alert("Seu navegador não suporta AJAX!");
                return false;
            }
        }
    }
    return xmlHttp;
}

self.onnotificationclick = function(NotificationEvent) {
	
	let url = NotificationEvent.target.origin;
    NotificationEvent.notification.close(); // Android needs explicit close.
    NotificationEvent.waitUntil(
        clients.matchAll({type: 'window', includeUncontrolled: true}).then( windowClients => {
            // Check if there is already a window/tab open with the target URL
            for (var i = 0; i < windowClients.length; i++) {
                var client = windowClients[i];
                // If so, just focus it.
                if (client.url.indexOf(url)>-1 && 'focus' in client) {
                    client.focus();
                    var notification = {title: NotificationEvent.notification.title,
										body: NotificationEvent.notification.body,
										icon:NotificationEvent.notification.icon};
                    
                    client.postMessage({'cmd':'show_popup_html_notification','notification':notification});
                    return;
                }
            }
            // If not, then open the target URL in a new window/tab.
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
	
	
	
	
	
	
	
	
	
};


