<?php
?>
<script>
/******************** GLOBAL VARIABLES ********************/
var SCOPES = ['https://www.googleapis.com/auth/drive','profile'];
var CLIENT_ID = '470569186386-bnlv623vf5mgagjfs6i3m9149oklk5s8.apps.googleusercontent.com';
var API_KEY = '87vGOWPQdSXbJflL0cu9QIuu';
var FOLDER_NAME = "";
var FOLDER_ID = "root";
var FOLDER_PERMISSION = true;
var FOLDER_LEVEL = 0;
var NO_OF_FILES = 1000;
var DRIVE_FILES = [];
var TOTAL_FOLDERS = [];
var TOTAL_FILES = [];
var FILE_COUNTER = 0;
var FOLDER_ARRAY = [];
var ASCENDING_ARRAY= [];
var cancel = 0;

/******************** AUTHENTICATION ********************/

function handleAuthClick(event) {
  gapi.auth2.getAuthInstance().signIn();
}

function handleClientLoad() {
  // Load the API client and auth2 library
  gapi.load('client:auth2', initClient);
  console.log("handleClientLoad");
}

function initClient() {
 gapi.client.init({
   //apiKey: API_KEY, //THIS IS OPTIONAL AND WE DONT ACTUALLY NEED THIS, BUT I INCLUDE THIS AS EXAMPLE
   clientId: CLIENT_ID,
   scope: SCOPES.join(' ')
 }).then(function () {
   // Listen for sign-in state changes.
   gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);
   // Handle the initial sign-in state.
   updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
 });

 console.log("initClient");
 console.log("clientid: " + CLIENT_ID);
}

function updateSigninStatus(isSignedIn) {
  if (isSignedIn) {
    $("#drive-box").show();
    $("#drive-box").css("display","inline-block");
        $("#login-box").hide();
        getDriveFiles();
  } else {
    $("#login-box").show();
        $("#drive-box").hide();
  }
  console.log("updateSigninStatus");
}

/******************** FILES ********************/

function getDriveFiles(){
  gapi.client.load('drive', 'v2', getFiles);
  console.log("getDriveFiles");
}

function getFiles(){
  console.log("getFiles");
    var query = "";
    var request = gapi.client.drive.files.list({
        'maxResults': NO_OF_FILES,
        'q': query
    });

    console.log("Num: " + NO_OF_FILES);

    request.execute(function (resp) {
       if (!resp.error) {
            DRIVE_FILES = resp.items;
       }else{
            console.log("Error: " + resp.error.message);
       }
    });
}

$(function(){

  $("#btnSubmit").click(function () {
    console.log("btnSubmit");
      $("#fUpload").click();
  });

    $("#fUpload").bind("change", function () {
        console.log("fUpload");
        var uploadObj = $("[id$=fUpload]");
        var file = uploadObj.prop("files")[0];
        var metadata = {
          'title': file.name,
          'description': "bytutorial.com File Upload",
          'mimeType': file.type || 'application/octet-stream',
          "parents": [{
            "kind": "drive#file",
            "id": FOLDER_ID
          }]
        };

        //if user upload an empty content, create a temp blob with a space content on it.
        if(file.size <= 0) {
          var emptyContent = " ";
          file = new Blob([emptyContent], {type: file.type || 'application/octet-stream'});
        }

        document.getElementById("fileName").value = " " + file.name;

        try {
          var uploader =new MediaUploader({
            file: file,
            token: gapi.auth2.getAuthInstance().currentUser.get().getAuthResponse().access_token,
            metadata: metadata,
            onError: function(response){
              var errorResponse = JSON.parse(response);
              console.log("Error: " + errorResponse.error.message);
              $("#fUpload").val("");
              $("#upload-percentage").hide(1000);
              getDriveFiles();
            },
            onComplete: function(response){
              $("#upload-percentage").hide(1000);
              var errorResponse = JSON.parse(response);
              if(errorResponse.message != null){
                console.log("Error: " + errorResponse.error.message);
                $("#fUpload").val("");
                getDriveFiles();
              }
              else{
                getDriveFiles();
                console.log("SUCCESS");
                $("#uploadModal").modal("show");
              }
            },
            onProgress: function(event) {
              showProgressPercentage(Math.round(((event.loaded/event.total)*100), 0));
            },
            params: {
              convert:false,
              ocr: false
            }
          });

          uploader.upload();
        }

        catch(exc){
          console.log("Error: " + exc);
          $("#fUpload").val("");
          getDriveFiles();
        }
    });
});

</script>
