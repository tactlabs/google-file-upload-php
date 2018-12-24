<html>
  <head></head>
  <body>

    <script>
    function makeApiCall() {
      var params = {
       
        spreadsheetId: '',

        range: 'Sheet1', 

       
        valueInputOption: 'RAW',

       
        insertDataOption: 'INSERT_ROWS', 
      };
	  
		var val =[];
		var name = document.getElementById('name').value;
		var mail = document.getElementById('mail_id').value;
		val.push(name);
		val.push(mail);
		console.log(val);
		
      var valueRangeBody = {
        "values": val
      };

      var request = gapi.client.sheets.spreadsheets.values.append(params, valueRangeBody);
      request.then(function(response) {
       
        console.log(response.result);
      }, function(reason) {
        console.error('error: ' + reason.result.error.message);
      });
    }

    function initClient() {
      var API_KEY = ''; 

      var CLIENT_ID = ''; 

      var SCOPE = 'https://www.googleapis.com/auth/spreadsheets';

      gapi.client.init({
        'apiKey': API_KEY,
        'clientId': CLIENT_ID,
        'scope': SCOPE,
        'discoveryDocs': ['https://sheets.googleapis.com/$discovery/rest?version=v4'],
      }).then(function() {
        gapi.auth2.getAuthInstance().isSignedIn.listen(updateSignInStatus);
        updateSignInStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
      });
    }

    function handleClientLoad() {
      gapi.load('client:auth2', initClient);
    }

    function updateSignInStatus(isSignedIn) {
      if (isSignedIn) {
        makeApiCall();
      }
    }

    function handleSignInClick(event) {
      gapi.auth2.getAuthInstance().signIn();
    }

    function handleSignOutClick(event) {
      gapi.auth2.getAuthInstance().signOut();
    }
    </script>
    <script async defer src="https://apis.google.com/js/api.js"
      onload="this.onload=function(){};handleClientLoad()"
      onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>
	
	<label>Name:</label><input type="text" id="name"></input><br><br>
	<label>Mail Id:</label><input type="text" id="mail_id"></input><br><br>
	
    <button id="signin-button" onclick="handleSignInClick()">Sign in</button>
    <button id="signout-button" onclick="handleSignOutClick()">Sign out</button>
	<button id="save" onclick="makeApiCall()">Insert</button>
  </body>
</html>