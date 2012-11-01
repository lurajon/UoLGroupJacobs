var Ajax = {
    
    xmlHttpPost : function (url, form, outputElement, async) {
        window.alert("AJAX!!");
        
        // default async if not defined
        if (!async) {
            async = false;
        }
        
        var xhr = null;
        
        // check if it is an old IE version
        
        if (window.ActiveXObject) {
            // WARNING!!! NOT TESTED
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        } else {
            xhr = new XMLHttpRequest();
        }
        
        xhr.xmlHttpReq.open('POST', url, async);
        xhr.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        if (async) {
            // check state etc..
        } 
        
        xhr.xmlHttpReq.send('parameter string');
        
        if (!async) {
            // do the sync stuff here
        }
    }
}