urlBase = 'http://corporatecontacts.club/LAMPAPI';

function doLogin()
{
    var login = document.getElementById("loginName").value;
    var password = document.getElementById("LoginPassword").value;
    
    var jsonPayload = '{"login" : "' + login + '", "password" : "' + password + '"}';
	var url = urlBase + '/Login.' + 'php';

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, false);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.send(jsonPayload);
		
		var jsonObject = JSON.parse( xhr.responseText );
		
		userId = jsonObject.id;
		
		if( userId < 1 )
		{
			document.getElementById("loginResult").innerHTML = "Username and/or Password are incorrect";
			return;
		}
		
		firstName = jsonObject.firstName;
		lastName = jsonObject.lastName;

		saveCookie();
	
		window.location.href = "color.html";
	}
	catch(err)
	{
		document.getElementById("loginResult").innerHTML = err.message;
    }
    
    function readCookie()
    {
        userId = -1;
        var data = document.cookie;
        var splits = data.split(",");
        for(var i = 0; i < splits.length; i++) 
        {
            var thisOne = splits[i].trim();
            var tokens = thisOne.split("=");
            if( tokens[0] == "firstName" )
            {
                firstName = tokens[1];
            }
            else if( tokens[0] == "lastName" )
            {
                lastName = tokens[1];
            }
            else if( tokens[0] == "userId" )
            {
                userId = parseInt( tokens[1].trim() );
            }
        }
        
        if( userId < 0 )
        {
            window.location.href = "index.html";
        }
        else
        {
            document.getElementById("userName").innerHTML = "Logged in as " + firstName + " " + lastName;
        }
    }

}
