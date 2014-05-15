function utilsInit() {
    urlParams = function() {
        // This function is anonymous, is executed immediately and 
        // the return value is assigned to QueryString!
        var query_string = {};
        var query = window.location.search.substring(1);//brings everything after the ?       
        var vars = query.split("&");
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            // If first entry with this name
            if (typeof query_string[pair[0]] === "undefined") {
                query_string[pair[0]] = pair[1];
                // If second entry with this name
            } else if (typeof query_string[pair[0]] === "string") {
                var arr = [query_string[pair[0]], pair[1]];
                query_string[pair[0]] = arr;
                // If third or later entry with this name
            } else {
                query_string[pair[0]].push(pair[1]);
            }
        }
        return query_string;
    }();

    myUser = {
        
        "id": (function() {
            return urlParams.id;
        }()),
        "nombre": (function() {
            return decodeURI(urlParams.nombre);
        }()),
        "apellidoP": (function() {
            return decodeURI(urlParams.apellidoP);
        }()),
        "apellidoM": (function() {
            return decodeURI(urlParams.apellidoM);
        }()),
        "telefono": (function() {
            return decodeURI(urlParams.telefono);
        }()),
        "email": (function() {
            return decodeURI(urlParams.email);
        }())
    };
}

function getSearchParameters() {
	var prmstr = window.location.search.substr(1);
	return prmstr != null && prmstr != "" ? transformToAssocArray(prmstr) : {};
}

function transformToAssocArray(prmstr) {
	var params = {};
	var prmarr = prmstr.split("&");
	for ( var i = 0; i < prmarr.length; i++) {
		var tmparr = prmarr[i].split("=");
		params[tmparr[0]] = tmparr[1];
	}
	return params;
}

function redirectTo(url) {
    window.location.href = encodeURI(url);
}