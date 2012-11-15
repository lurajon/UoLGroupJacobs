var Ajax = {
    
    xmlHttpPost : function (url, form, outputElementId, async) {
        var outputElement = document.getElementById(outputElementId);
        
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
        
        xhr.open('POST', url, async);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        if (async) {
            xhr.onreadystatechange=function() {
                if (xmlxhrhttp.readyState==4 && xhr.status==200) {
                    this.printResponse(outputElement, xhr.responseText);
                }
            };
        } 
        
        xhr.send(this.buildQueryString(form));
        
        if (!async) {
            this.printResponse(outputElement, xhr.responseText);
        }
    },
    
    xmlHttpGet : function(url, async) {
        var xhr = null;
        
        // check if it is an old IE version
        if (window.ActiveXObject) {
            // WARNING!!! NOT TESTED
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        } else {
            xhr = new XMLHttpRequest();
        }
        
        if (async) {
            xhr.onreadystatechange=function() {
                if (xmlxhrhttp.readyState==4 && xhr.status==200) {
                    return xhr.responseText;
                }
            };
        } 
        
        xhr.open('GET', url, async);
        xhr.send(null);
        
        return xhr.responseText;
	},
    
    printResponse : function(outputElement, response) {
        outputElement.innerHTML = response;
    },
    
    buildQueryString : function (form) {
        var queryString = '';
        
        var elements = form.elements;
        
        for (var i = 0; i < elements.length; i++) {
            var element = elements[i];
            
            if (!element.name) {
                continue;
            }
            
            if (queryString.length > 0) {
                queryString += '&';
            }
            
            if (element.type == 'radio') {
                queryString += this.getRadioParameter(element);
            } else if (element.type.indexOf('select') != -1) {
                queryString += this.getSelectParameter(element);
            } else if (element.type == 'checkbox') {
                queryString += this.getCheckboxParameter(element);
            } else {
                queryString += this.getDefaultTypeParameter(element);
            }
        }
        
        return queryString;
    },
    
    getRadioParameter : function(element) {
        if (element.checked) {
            return element.name + '=' + element.value;
        }
        
        return '';
    },
    
    getDefaultTypeParameter : function(element) {
        
        return element.name + '=' + element.value;
        
    },
    
    getSelectParameter : function(element) {
        // find selected
        for (var i = 0; i < element.options.length; i++) {
            var option = element.options[i];
            
            if (option.selected) {
                return element.name + '=' + option.value ? option.value : option.text;
            }
        }

        return '';
    },
    
    getCheckboxParameter : function(element) {
        if (element.checked) {
            return element.name + '=' + element.value ? element.value : "on";
        }
        
        return '';
    }
}