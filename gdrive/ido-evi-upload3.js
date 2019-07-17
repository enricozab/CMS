/******************** GLOBAL VARIABLES ********************/
var SCOPES = ['https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/drive','profile'];
var CLIENT_ID = '470569186386-bnlv623vf5mgagjfs6i3m9149oklk5s8.apps.googleusercontent.com';
var API_KEY = '87vGOWPQdSXbJflL0cu9QIuu';
var FOLDER_NAME = "";
var FOLDER_ID = "root";
var FOLDER_PERMISSION = true;
var FOLDER_LEVEL = 0;
var NO_OF_FILES = 100;
var DRIVE_FILES = [];
var TOTAL_FOLDERS = [];
var TOTAL_FILES = [];
var FILE_COUNTER = 0;
var FOLDER_ARRAY = [];
var ASCENDING_ARRAY= [], WITNESS_ARRAY = [];
var cancel = 0, buttonNum, caseFilesID = "nothing", evidenceFilesID = "none";
var madeIDN = 0, folderData = 'hi', newEvi = 0;
var college, course, idn, graduating, fullIDN, page, caseNum, btnNum, userName, offense, type, finalDesc, witness;
/******************** AUTHENTICATION ********************/


function handle(data) {
	handleClientLoad();
	/**************** NEW ****************/
	console.log("DATA: " + data);
	data = data.split("/");

	page = data[4];
	console.log("PAGE: " + page);
	if (page == "IDO-VIEW-CASE" || page == "SDFOD-VIEW-CASE" || page == "AULC-VIEW-CASE" || page == "ULC-VIEW-CASE") {
		college = data[0];
		course = data[1];
		graduating = data[2];
		fullIDN = data[3];
		caseNum = "Case #" + data[5];
		idn = fullIDN.substring(0, 3);
	}

	else {
		college = data[0];
		course = data[1];
		idn = data[2];
		graduating = data[3];
		fullIDN = data[4];
	}
	//
	// console.log("CASE NUM: " + caseNum);
	console.log("COURSE: " + course);
	console.log("COLLEGE: " + college);
	console.log("IDN: " + idn);
	console.log("GRADUATING: " + graduating);
	console.log("CASENUM: " + caseNum);
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

function updateButtonNum(data) {
	buttonNum = data;
}

function updateSigninStatus(isSignedIn) {
	if (isSignedIn) {
		$("#drive-box").show();
		$("#drive-box").css("display","inline-block");
        $("#login-box").hide();
        getDriveFiles();
	} else {
		gapi.auth2.getAuthInstance().signIn();
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

	var request = gapi.client.drive.about.get();
    var obj = {};
    request.execute(function(resp) {
       if (!resp.error) {
         userName = resp.name;
         console.log("USER NAME: " + userName);

         var query = "";

         if (userName == "Thea Mae Firaza") {
           console.log("yes");
           $(".button-opt").show();
           query = "trashed=false and '" + FOLDER_ID + "' in parents";
         }

         else {
           $(".button-opt").show();
           query = (FOLDER_ID == "root") ? "trashed=false and sharedWithMe" : "trashed=false and '" + FOLDER_ID + "' in parents";
           if (FOLDER_ID != "root" && FOLDER_PERMISSION == "true") {
             $(".button-opt").show();
           }
         }

         var request = gapi.client.drive.files.list({
             'maxResults': NO_OF_FILES,
             'q': query
         });

       request.execute(function (resp) {
          if (!resp.error) {
              DRIVE_FILES = resp.items;

              for (var i = 0; i < DRIVE_FILES.length; i++) {
                  DRIVE_FILES[i].fileType =  (DRIVE_FILES[i].fileExtension == null) ? "folder" : "file";

                  if (DRIVE_FILES[i].fileType == "folder") {
                      if (DRIVE_FILES[i].title == "CMS") {
                          console.log("CMS");
                          FOLDER_ID = DRIVE_FILES[i].id;
                      }
                  }
              }

              console.log("folder id CMS: " + FOLDER_ID);
              getCMSFiles();
          }
          else{
               console.log("Error: " + resp.error.message);
          }
       });

       } else{
            console.log("Error: " + resp.error.message);
       }
   });
}

/**************** NEW ****************/
// basically u loop thru it multiple times until u reach student folders
// this is down only for the upload shit

function collegeFiles() {
    console.log("collegeFiles");

    for (var i = 0; i < DRIVE_FILES.length; i++) {
      DRIVE_FILES[i].fileType =  (DRIVE_FILES[i].fileExtension == null) ? "folder" : "file";

      if (DRIVE_FILES[i].fileType == "folder") {
				console.log("DIS FOLDER: "  + college);
          if (DRIVE_FILES[i].title == college) {
              console.log("college");

              FOLDER_ID = DRIVE_FILES[i].id;
              console.log("folder id College: " + FOLDER_ID);
          }
      }
    }

    var query = "";

		query = "trashed=false and '" + FOLDER_ID + "' in parents";
    var request = gapi.client.drive.files.list({
        'maxResults': NO_OF_FILES,
        'q': query
    });

    request.execute(function (resp) {
       if (!resp.error) {
           DRIVE_FILES = resp.items;
           courseFiles();
       }
       else{
            console.log("Error: " + resp.error.message);
       }
    });
}

function courseFiles() {
    console.log("courseFiles");

    for (var i = 0; i < DRIVE_FILES.length; i++) {
      DRIVE_FILES[i].fileType =  (DRIVE_FILES[i].fileExtension == null) ? "folder" : "file";

      if (DRIVE_FILES[i].fileType == "folder") {
          if (DRIVE_FILES[i].title == course) {
              console.log("course");

              FOLDER_ID = DRIVE_FILES[i].id;
              console.log("folder id Course: " + FOLDER_ID);
          }
      }
    }

    var query = "";
    query = "trashed=false and '" + FOLDER_ID + "' in parents";

    var request = gapi.client.drive.files.list({
        'maxResults': NO_OF_FILES,
        'q': query
    });

    request.execute(function (resp) {
       if (!resp.error) {
           DRIVE_FILES = resp.items;
           graduatingFiles();
       }
       else{
            console.log("Error: " + resp.error.message);
       }
    });
}

function idnFiles() {
    console.log("idnFiles");

    for (var i = 0; i < DRIVE_FILES.length; i++) {
      DRIVE_FILES[i].fileType =  (DRIVE_FILES[i].fileExtension == null) ? "folder" : "file";

      if (DRIVE_FILES[i].fileType == "folder") {
          if (DRIVE_FILES[i].title == idn) {
              console.log("IDN");

              FOLDER_ID = DRIVE_FILES[i].id;
              console.log("folder id IDN: " + FOLDER_ID);
          }
      }
    }

    var query = "";
    query = "trashed=false and '" + FOLDER_ID + "' in parents";

    var request = gapi.client.drive.files.list({
        'maxResults': NO_OF_FILES,
        'q': query
    });

    request.execute(function (resp) {
       if (!resp.error) {
           DRIVE_FILES = resp.items;

					 console.log("Page: " + page);

					 if (page == "IDO-VIEW-CASE" || page == "SDFOD-VIEW-CASE" || page == "AULC-VIEW-CASE" || "ULC-VIEW-CASE") {
						 getFullIDNFiles();
					 }

					 if (folderData == 'hi') {
						 $('#waitModal').modal("hide");
						 $("#folderModal").modal("show");
					 }

					 else {
						 getFullIDNFiles();
					 }
       }
       else{
            console.log("Error: " + resp.error.message);
       }
    });
}

function graduatingFiles() {
    console.log("graduatingFiles");

    for (var i = 0; i < DRIVE_FILES.length; i++) {
      DRIVE_FILES[i].fileType =  (DRIVE_FILES[i].fileExtension == null) ? "folder" : "file";

      if (DRIVE_FILES[i].fileType == "folder") {
          if (DRIVE_FILES[i].title == graduating) {
              console.log("GRADUATING");

              FOLDER_ID = DRIVE_FILES[i].id;
              console.log("folder id GRADUATING: " + FOLDER_ID);
          }
      }
    }

    var query = "";
    query = "trashed=false and '" + FOLDER_ID + "' in parents";

    var request = gapi.client.drive.files.list({
        'maxResults': NO_OF_FILES,
        'q': query
    });

    request.execute(function (resp) {
       if (!resp.error) {
           DRIVE_FILES = resp.items;

            if (madeIDN == 1) {
                getFullIDNFiles();
            }

            else{
                idnFiles();
            }
       }
       else{
            console.log("Error: " + resp.error.message);
       }
    });
}

function getFullIDNFiles() {
    console.log("getFullIDNFiles");
		console.log("full IDN Update: " + fullIDN);
		console.log("folderData: " + folderData);

    for (var i = 0; i < DRIVE_FILES.length; i++) {
      DRIVE_FILES[i].fileType =  (DRIVE_FILES[i].fileExtension == null) ? "folder" : "file";

      if (DRIVE_FILES[i].fileType == "folder") {
          if (DRIVE_FILES[i].title == fullIDN) {

              FOLDER_ID = DRIVE_FILES[i].id;
              console.log("folder id FullIDNFiles: " + FOLDER_ID);
          }
      }
    }

    var query = "";
    query = "trashed=false and '" + FOLDER_ID + "' in parents";

    var request = gapi.client.drive.files.list({
        'maxResults': NO_OF_FILES,
        'q': query
    });

    request.execute(function (resp) {
       if (!resp.error) {
            DRIVE_FILES = resp.items;
            console.log("folderData: " + folderData);
            if(folderData != 'hi') {
                addCaseFolder();
            }

            if (page == "IDO-VIEW-CASE" || page == "SDFOD-VIEW-CASE" || page == "AULC-VIEW-CASE" || page == "ULC-VIEW-CASE") {
                getCaseFiles();
            }
       }
       else{
            console.log("Error: " + resp.error.message);
       }
    });
}

function getCaseFiles() {
    console.log("getCaseFiles");

    for (var i = 0; i < DRIVE_FILES.length; i++) {
        DRIVE_FILES[i].fileType =  (DRIVE_FILES[i].fileExtension == null) ? "folder" : "file";

        if (DRIVE_FILES[i].fileType == "folder") {
            if (DRIVE_FILES[i].title == caseNum) {
    
                FOLDER_ID = DRIVE_FILES[i].id;
                caseFilesID = DRIVE_FILES[i].id;
                console.log("folder id CaseFiles: " + FOLDER_ID);
            }
        }
    }

    var query = "";
    query = "trashed=false and '" + FOLDER_ID + "' in parents";

    var request = gapi.client.drive.files.list({
        'maxResults': NO_OF_FILES,
        'q': query
    });

    request.execute(function (resp) {
       if (!resp.error) {
            DRIVE_FILES = resp.items;

            if (page == "IDO-VIEW-CASE" || page == "SDFOD-VIEW-CASE" || page == "AULC-VIEW-CASE" || page == "ULC-VIEW-CASE") {
                $("#waitModal").modal("hide");
                $('#driveModal').modal("show");
                $("#uploading").hide();

                $('#first').hide();
                $('#uploadPanel').show();
            }
       }
       else{
            console.log("Error: " + resp.error.message);
       }
    });
}

function getCaseFiles2() {
    console.log("getCaseFiles2");

    console.log(FOLDER_ID);

    var query = "";
	query = "trashed=false and '" + FOLDER_ID + "' in parents";
    var request = gapi.client.drive.files.list({
        'maxResults': NO_OF_FILES,
        'q': query
    });

    request.execute(function (resp) {
        if (!resp.error) {
             DRIVE_FILES = resp.items;
             console.log(DRIVE_FILES.length);
             getEvidenceFiles();
        }
        else{
            console.log("Error: " + resp.error.message);
        }
     });
}

function getEvidenceFiles2() {
    console.log("getEvidenceFiles2");

    if(evidenceFilesID == "none") {
        FOLDER_ID = evidenceFilesID;
    }
    
    var query = "";
	query = "trashed=false and '" + FOLDER_ID + "' in parents";
    var request = gapi.client.drive.files.list({
        'maxResults': NO_OF_FILES,
        'q': query
    });

    request.execute(function (resp) {
        if (!resp.error) {
             DRIVE_FILES = resp.items;
             console.log(DRIVE_FILES.length);
             getWitnessFiles();
        }
        else{
            console.log("Error: " + resp.error.message);
        }
     });
}

function getEvidenceFiles() {
    console.log("getEvidenceFiles");

    for (var i = 0; i < DRIVE_FILES.length; i++) {
        DRIVE_FILES[i].fileType =  (DRIVE_FILES[i].fileExtension == null) ? "folder" : "file";

        if (DRIVE_FILES[i].fileType == "folder") {
            if (DRIVE_FILES[i].title == "Evidence") {
                FOLDER_ID = DRIVE_FILES[i].id;
                evidenceFilesID = DRIVE_FILES[i].id;
                console.log("folder id Evidence: " + FOLDER_ID);
            }
        }
    }

    var query = "";
    query = "trashed=false and '" + FOLDER_ID + "' in parents";

    var request = gapi.client.drive.files.list({
        'maxResults': NO_OF_FILES,
        'q': query
    });

    request.execute(function (resp) {
        if (!resp.error) {
            DRIVE_FILES = resp.items;
            checkWitness();
        }
        else {
            console.log("Error: " + resp.error.message);
        }
    });
}

function getWitnessFiles() {
    console.log("getWitnessFiles");

    for (var i = 0; i < DRIVE_FILES.length; i++) {
        DRIVE_FILES[i].fileType =  (DRIVE_FILES[i].fileExtension == null) ? "folder" : "file";

        if (DRIVE_FILES[i].fileType == "folder") {
            if (DRIVE_FILES[i].title == witness) {
                FOLDER_ID = DRIVE_FILES[i].id;
                console.log("folder id Witness: " + FOLDER_ID);
            }
        }
    }

    var query = "";
    query = "trashed=false and '" + FOLDER_ID + "' in parents";

    var request = gapi.client.drive.files.list({
        'maxResults': NO_OF_FILES,
        'q': query
    });

    request.execute(function (resp) {
       if (!resp.error) {
            DRIVE_FILES = resp.items;
            submitThis();
       }
       else{
            console.log("Error: " + resp.error.message);
       }
    });
}

function checkEviFolder() {
    console.log("checkEviFolder");

    // checks if not first time to upload evi

    var checker = false;

    for (var i = 0; i < DRIVE_FILES.length; i++) {
        DRIVE_FILES[i].fileType =  (DRIVE_FILES[i].fileExtension == null) ? "folder" : "file";

        console.log("drive file: " + DRIVE_FILES[i].title);
        if (DRIVE_FILES[i].fileType == "folder") {
            if (DRIVE_FILES[i].title == "Evidence") {
                checker = true;
            }
        }
    }

    console.log("checker: " + checker);

    // if (FOLDER_ID == caseFilesID || DRIVE_FILES.length == 0) {
    //     // its the first time, make evidence folder

    //     console.log("evidence - first time");
    //     addEvidenceFolder();
    // }

    // else {
    //     // not first time, get evidence folder ID
    //     // using drive files of case folder

    //     console.log("evidence - not first time");
    //     FOLDER_ID = caseFilesID;
    //     getCaseFiles2();
    //     // getEvidenceFiles();
    // }
}

function checkWitness() {
    console.log("checkWitness");
    console.log("Witness: " + witness);

    // check if evidence folder length is 0

    if (DRIVE_FILES.length == 0) {
        addWitnessFolder();
    }

    else {
        // check if witness folder exists

        console.log("DRIVE: " + DRIVE_FILES.length);
        console.log("current id: " + FOLDER_ID);
        console.log("evidenceFilesID: " + evidenceFilesID);

        var checkWitness = 0;

        if (FOLDER_ID != evidenceFilesID) {
            getEvidenceFiles2();
        }

        else {
            for (var i = 0; i < DRIVE_FILES.length; i++) {
                DRIVE_FILES[i].fileType =  (DRIVE_FILES[i].fileExtension == null) ? "folder" : "file";
    
                if (DRIVE_FILES[i].fileType == "folder") {
                    if (DRIVE_FILES[i].title == witness) {
                        // witness exists
                        // get witness folder id and its files

                        checkWitness = 1;
    
                        FOLDER_ID = DRIVE_FILES[i].id;
                        console.log("folder id WitnessFiles: " + FOLDER_ID);
    
                        var query = "";
                        query = "trashed=false and '" + FOLDER_ID + "' in parents";
    
                        var request = gapi.client.drive.files.list({
                            'maxResults': NO_OF_FILES,
                            'q': query
                        });
    
                        request.execute(function (resp) {
                            if (!resp.error) {
                                DRIVE_FILES = resp.items;
                                console.log("here");
                                submitThis();
                            }
                            else {
                                console.log("Error: " + resp.error.message);
                            }
                        });
                    }
                }
            }

            if (checkWitness == 0) {
                // witness doesnt exist
                console.log("witness doesnt exist");
                addWitnessFolder();
            }

            console.log("check witness: " + checkWitness);
        }
    }
}

function getCMSFiles()  {
    console.log("getCMSFiles");

    var query = "";
    query = "trashed=false and '" + FOLDER_ID + "' in parents";

    var request = gapi.client.drive.files.list({
        'maxResults': NO_OF_FILES,
        'q': query
    });

    request.execute(function (resp) {
       if (!resp.error) {
           DRIVE_FILES = resp.items;
           collegeFiles();
       }
       else{
        console.log("Error: " + resp.error.message);
       }
    });
}

function addCaseFolder() {
	console.log("addCaseFolder");
	
	var access_token =  gapi.auth2.getAuthInstance().currentUser.get().getAuthResponse().access_token;
	var request = gapi.client.request({
			'path': '/drive/v2/files/',
			'method': 'POST',
			'headers': {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + access_token,
			},
			'body':{
				"title" : folderData,
				"mimeType" : "application/vnd.google-apps.folder",
				"parents": [{
				"kind": "drive#file",
				"id": FOLDER_ID
			}]
			}
	});

	request.execute(function(resp) {
			if (!resp.error) {
				console.log("CASE FOLDER DONE");
				$('#waitModal').modal("hide");
			}else{
			hideStatus();
			hideLoading();
			console.log("Error: " + resp.error.message);
			}
	});
}

function addEvidenceFolder() {
	console.log("addEvidenceFolder");

	var access_token =  gapi.auth2.getAuthInstance().currentUser.get().getAuthResponse().access_token;
	var request = gapi.client.request({
			'path': '/drive/v2/files/',
			'method': 'POST',
			'headers': {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + access_token,
			},
			'body':{
				"title" : "Evidence",
				"mimeType" : "application/vnd.google-apps.folder",
				"parents": [{
				"kind": "drive#file",
				"id": FOLDER_ID
			}]
			}
	});

	request.execute(function(resp) {
        if (!resp.error) {
            console.log("EVIDENCE FOLDER DONE");
            getCaseFiles2();
        } 
        
        else {
            console.log("Error: " + resp.error.message);
        }
	});
}

function addWitnessFolder() {
    console.log("addWitnessFolder");

    var access_token =  gapi.auth2.getAuthInstance().currentUser.get().getAuthResponse().access_token;
    var request = gapi.client.request({
            'path': '/drive/v2/files/',
            'method': 'POST',
            'headers': {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + access_token,
            },
            'body':{
                "title" : witness,
                "mimeType" : "application/vnd.google-apps.folder",
                "parents": [{
                "kind": "drive#file",
                "id": FOLDER_ID
            }]
            }
    });

    request.execute(function(resp) {
        if (!resp.error) {
            console.log("WITNESS FOLDER DONE");
            getEvidenceFiles2();
        } 
        else {
            console.log("Error: " + resp.error.message);
        }
    });
}

function showProgressPercentage(percentageValue) {
    if ($("#upload-percentage").length == 0) {
        //$("#drive-box").prepend("<div id='upload-percentage' class='flash'></div>");
    }
    if (!$("#upload-percentage").is(":visible")) {
        $("#upload-percentage").show(1000);
    }
    $("#upload-percentage").html(percentageValue.toString() + "%");
}

/**************** NEW ****************/

function buttonAddfolder(folder) {
	folderData = folder;
	console.log("CASE FOLDER: " + folderData);
	console.log("button-addfolder");
	$('#folderModal').modal("hide");
	$('#waitModal').modal("show");

	for (var i = 0; i < DRIVE_FILES.length; i++) {
		DRIVE_FILES[i].fileType =  (DRIVE_FILES[i].fileExtension == null) ? "folder" : "file";

		if (DRIVE_FILES[i].fileType == "folder") {
				if (DRIVE_FILES[i].title == fullIDN) {
					idnFiles();
				}

				else {
					var access_token =  gapi.auth2.getAuthInstance().currentUser.get().getAuthResponse().access_token;
					var request = gapi.client.request({
						 'path': '/drive/v2/files/',
						 'method': 'POST',
						 'headers': {
							 'Content-Type': 'application/json',
							 'Authorization': 'Bearer ' + access_token,
						 },
						 'body':{
							 "title" : fullIDN,
							 "mimeType" : "application/vnd.google-apps.folder",
							 "parents": [{
								"kind": "drive#file",
								"id": FOLDER_ID
							}]
						 }
					});

					request.execute(function(resp) {
						 if (!resp.error) {
							madeIDN = 1;
							console.log("IDN FOLDER DONE");

						  idnFiles();
						 }else{
							hideStatus();
							hideLoading();
							console.log("Error: " + resp.error.message);
						 }
					});
				}
		}
	}
}
//
// $("#button-addfolder").click(function () {
// 	console.log("button-addfolder");
//
// 	var access_token =  gapi.auth2.getAuthInstance().currentUser.get().getAuthResponse().access_token;
// 	var request = gapi.client.request({
// 		 'path': '/drive/v2/files/',
// 		 'method': 'POST',
// 		 'headers': {
// 			 'Content-Type': 'application/json',
// 			 'Authorization': 'Bearer ' + access_token,
// 		 },
// 		 'body':{
// 			 "title" : fullIDN,
// 			 "mimeType" : "application/vnd.google-apps.folder",
// 			 "parents": [{
// 				"kind": "drive#file",
// 				"id": FOLDER_ID
// 			}]
// 		 }
// 	});
//
// 	request.execute(function(resp) {
// 		 if (!resp.error) {
// 			madeIDN = 1;
// 			getDriveFiles();
// 		 }else{
// 			hideStatus();
// 			hideLoading();
// 			console.log("Error: " + resp.error.message);
// 		 }
// 	});
// });


function submitButton (event) {
	console.log("btnSubmit");
		$("#fUpload").click();
}

function btnSubmit(data) {

	console.log("DATA BTNSUMIT: " + data);

	data = data.split("|");

	page = data[3];

	if (page == "IDO-VIEW") {
		btnNum = data[0];
		offense = data[1];
        type = data[2];
        getCaseFiles();
        finalDesc = type + ", " + offense;
	    submitThis();
	}

	else if(page == "IDO-VIEW-EVIDENCE") {
		btnNum = data[0];
		offense = data[1];
        type = data[2];
        witness = data[4]

        checkEviFolder();

        finalDesc = type + ", " + offense;
	}

	else  {
		offense = data[0];
        type = data[1];
        finalDesc = type + ", " + offense;
	    submitThis();
    }
}

function sdfodBtnSubmit() {
	console.log("sdfodBtnSubmit");
	// $('#updateTable').click();
	// $("#fUpload").click();
	submitThis();
}

function submitThis(){
	console.log("submit");
	$("#fUpload").click();
}

$(document).ready(function () {

	$("#btnSubmit").click(function () {
        console.log("btnSubmit");
        $("#fUpload").click();
    });
    

    $("#fUpload").bind("change", function () {
        console.log("fUpload");
        console.log("BTN: " + btnNum);

        $("#waitModal").modal("show");

        var uploadObj = $("[id$=fUpload]");
        var file = uploadObj.prop("files")[0];
        var metadata = {
            'title': file.name,
            'description': finalDesc,
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

        showProgressPercentage(0);

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

                    console.log("SUCCESS UPLOAD");
                    $("#successModal").modal("show");
                    $("#uploadModal").hide();

                    if(errorResponse.message != null){
                        console.log("Error: " + errorResponse.error.message);
                        $("#fUpload").val("");
                        getDriveFiles();
                    }

                    else {

                        if (page == "IDO-VIEW" || page == "IDO-VIEW-EVIDENCE" || page == "SDFOD-VIEW-CASE" || page == "AULC-VIEW-CASE") {
                            $("#waitModal").modal("hide");

                            if (btnNum == "two") {
                                $("#two").attr('disabled', true).text("Submitted");
                                console.log("responseUpload");
                                // $('#responseUpload').click();
                                // $('#responseUpload').trigger('click');
                                // console.log("hi");
                            }

                            else if (btnNum == "three") {
                                $("#three").attr('disabled', true).text("Submitted");
                                //$('#checkingForms').click();
                            }
                            else if (btnNum == "four") {
                                //$("#four").attr('disabled', true).text("Submitted");
                                //$('#checkingForms').click();
                            }
                            else if (btnNum == "five") {
                                //$("#five").attr('disabled', true).text("Submitted");
                                //$('#checkingForms').click();
                                //$('#responseUpload').click();
                            }

                            else if (btnNum == "six") {
                                //$("#five").attr('disabled', true).text("Submitted");
                                //$('#checkingForms').click();
                                //$('#responseUpload').click();
                            }

                            else {
                                $("#one").attr('disabled', true).text("Submitted");
                                //$('#checkingForms').click();
                                //$('#incidentUpload').click();
                            }
                        }

                        else {
                            getDriveFiles();
                            console.log("SUCCESS");
                            $("#uploadModal").hide();
                            $("#waitModal").modal("hide");
                            $("#uploadModal").modal("show");
                            $("#successModal").modal("show");
                        }

                        $("#successModal").modal("show");
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
