<?php include 'hdo.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Calendar</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

  <?php
    include 'hdo-notif-queries.php'
  ?>

    <div id="wrapper">

        <?php include 'hdo-sidebar.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Gmail</h3>
                </div>
                <div class="container">

                  <a href="#compose-modal" data-toggle="modal" id="compose-button" class="btn btn-primary pull-right hidden">Compose</a>

                  <button id="authorize-button" class="btn btn-primary hidden">Authorize</button>

                  <table class="table table-striped table-inbox hidden">
                    <thead>
                      <tr>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Date/Time</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
                <div>
                  <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          <h4 class="modal-title">Compose</h4>
                        </div>
                        <form onsubmit="return sendEmail();">
                          <div class="modal-body">
                            <div class="form-group">
                              <input type="email" class="form-control" id="compose-to" placeholder="To" required />
                            </div>

                            <div class="form-group">
                              <input type="text" class="form-control" id="compose-subject" placeholder="Subject" required />
                            </div>

                            <div class="form-group">
                              <textarea class="form-control" id="compose-message" placeholder="Message" rows="10" required></textarea>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="send-button" class="btn btn-primary">Send</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="reply-modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          <h4 class="modal-title">Reply</h4>
                        </div>
                        <form onsubmit="return sendReply();">
                          <input type="hidden" id="reply-message-id" />

                          <div class="modal-body">
                            <div class="form-group">
                              <input type="text" class="form-control" id="reply-to" disabled />
                            </div>

                            <div class="form-group">
                              <input type="text" class="form-control disabled" id="reply-subject" disabled />
                            </div>

                            <div class="form-group">
                              <textarea class="form-control" id="reply-message" placeholder="Message" rows="10" required></textarea>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="reply-button" class="btn btn-primary">Send</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
                  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

                  <script type="text/javascript">
                    var clientId = '847418612593-8udibtfp8mt565n64vq8rv50qbdr4di4.apps.googleusercontent.com';
                    var apiKey = 'AIzaSyAwmG6VqTGO9oYmMhYBGwNh6HSBMt021cg';
                    var scopes =
                      'https://www.googleapis.com/auth/gmail.readonly '+
                      'https://www.googleapis.com/auth/gmail.send';
                    function handleClientLoad() {
                      gapi.client.setApiKey(apiKey);
                      window.setTimeout(checkAuth, 1);
                    }
                    function checkAuth() {
                      gapi.auth.authorize({
                        client_id: clientId,
                        scope: scopes,
                        immediate: true
                      }, handleAuthResult);
                    }
                    function handleAuthClick() {
                      gapi.auth.authorize({
                        client_id: clientId,
                        scope: scopes,
                        immediate: false
                      }, handleAuthResult);
                      return false;
                    }
                    function handleAuthResult(authResult) {
                      if(authResult && !authResult.error) {
                        loadGmailApi();
                        $('#authorize-button').remove();
                        $('.table-inbox').removeClass("hidden");
                        $('#compose-button').removeClass("hidden");
                      } else {
                        $('#authorize-button').removeClass("hidden");
                        $('#authorize-button').on('click', function(){
                          handleAuthClick();
                        });
                      }
                    }
                    function loadGmailApi() {
                      gapi.client.load('gmail', 'v1', displayInbox);
                    }
                    function displayInbox() {
                      var request = gapi.client.gmail.users.messages.list({
                        'userId': 'me',
                        'labelIds': 'INBOX',
                        'maxResults': 10
                      });
                      request.execute(function(response) {
                        $.each(response.messages, function() {
                          var messageRequest = gapi.client.gmail.users.messages.get({
                            'userId': 'me',
                            'id': this.id
                          });
                          messageRequest.execute(appendMessageRow);
                        });
                      });
                    }
                    function appendMessageRow(message) {
                      $('.table-inbox tbody').append(
                        '<tr>\
                          <td>'+getHeader(message.payload.headers, 'From')+'</td>\
                          <td>\
                            <a href="#message-modal-' + message.id +
                              '" data-toggle="modal" id="message-link-' + message.id+'">' +
                              getHeader(message.payload.headers, 'Subject') +
                            '</a>\
                          </td>\
                          <td>'+getHeader(message.payload.headers, 'Date')+'</td>\
                        </tr>'
                      );
                      var reply_to = (getHeader(message.payload.headers, 'Reply-to') !== '' ?
                        getHeader(message.payload.headers, 'Reply-to') :
                        getHeader(message.payload.headers, 'From')).replace(/\"/g, '&quot;');
                      var reply_subject = 'Re: '+getHeader(message.payload.headers, 'Subject').replace(/\"/g, '&quot;');
                      $('body').append(
                        '<div class="modal fade" id="message-modal-' + message.id +
                            '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">\
                          <div class="modal-dialog modal-lg">\
                            <div class="modal-content">\
                              <div class="modal-header">\
                                <button type="button"\
                                        class="close"\
                                        data-dismiss="modal"\
                                        aria-label="Close">\
                                  <span aria-hidden="true">&times;</span></button>\
                                <h4 class="modal-title" id="myModalLabel">' +
                                  getHeader(message.payload.headers, 'Subject') +
                                '</h4>\
                              </div>\
                              <div class="modal-body">\
                                <iframe id="message-iframe-'+message.id+'" srcdoc="<p>Loading...</p>">\
                                </iframe>\
                              </div>\
                              <div class="modal-footer">\
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\
                                <button type="button" class="btn btn-primary reply-button" data-dismiss="modal" data-toggle="modal" data-target="#reply-modal"\
                                onclick="fillInReply(\
                                  \''+reply_to+'\', \
                                  \''+reply_subject+'\', \
                                  \''+getHeader(message.payload.headers, 'Message-ID')+'\'\
                                  );"\
                                >Reply</button>\
                              </div>\
                            </div>\
                          </div>\
                        </div>'
                      );
                      $('#message-link-'+message.id).on('click', function(){
                        var ifrm = $('#message-iframe-'+message.id)[0].contentWindow.document;
                        $('body', ifrm).html(getBody(message.payload));
                      });
                    }
                    function sendEmail()
                    {
                      $('#send-button').addClass('disabled');
                      sendMessage(
                        {
                          'To': $('#compose-to').val(),
                          'Subject': $('#compose-subject').val()
                        },
                        $('#compose-message').val(),
                        composeTidy
                      );
                      return false;
                    }
                    function composeTidy()
                    {
                      $('#compose-modal').modal('hide');
                      $('#compose-to').val('');
                      $('#compose-subject').val('');
                      $('#compose-message').val('');
                      $('#send-button').removeClass('disabled');
                    }
                    function sendReply()
                    {
                      $('#reply-button').addClass('disabled');
                      sendMessage(
                        {
                          'To': $('#reply-to').val(),
                          'Subject': $('#reply-subject').val(),
                          'In-Reply-To': $('#reply-message-id').val()
                        },
                        $('#reply-message').val(),
                        replyTidy
                      );
                      return false;
                    }
                    function replyTidy()
                    {
                      $('#reply-modal').modal('hide');
                      $('#reply-message').val('');
                      $('#reply-button').removeClass('disabled');
                    }
                    function fillInReply(to, subject, message_id)
                    {
                      $('#reply-to').val(to);
                      $('#reply-subject').val(subject);
                      $('#reply-message-id').val(message_id);
                    }
                    function sendMessage(headers_obj, message, callback)
                    {
                      var email = '';
                      for(var header in headers_obj)
                        email += header += ": "+headers_obj[header]+"\r\n";
                      email += "\r\n" + message;
                      var sendRequest = gapi.client.gmail.users.messages.send({
                        'userId': 'me',
                        'resource': {
                          'raw': window.btoa(email).replace(/\+/g, '-').replace(/\//g, '_')
                        }
                      });
                      return sendRequest.execute(callback);
                    }
                    function getHeader(headers, index) {
                      var header = '';
                      $.each(headers, function(){
                        if(this.name.toLowerCase() === index.toLowerCase()){
                          header = this.value;
                        }
                      });
                      return header;
                    }
                    function getBody(message) {
                      var encodedBody = '';
                      if(typeof message.parts === 'undefined')
                      {
                        encodedBody = message.body.data;
                      }
                      else
                      {
                        encodedBody = getHTMLPart(message.parts);
                      }
                      encodedBody = encodedBody.replace(/-/g, '+').replace(/_/g, '/').replace(/\s/g, '');
                      return decodeURIComponent(escape(window.atob(encodedBody)));
                    }
                    function getHTMLPart(arr) {
                      for(var x = 0; x <= arr.length; x++)
                      {
                        if(typeof arr[x].parts === 'undefined')
                        {
                          if(arr[x].mimeType === 'text/html')
                          {
                            return arr[x].body.data;
                          }
                        }
                        else
                        {
                          return getHTMLPart(arr[x].parts);
                        }
                      }
                      return '';
                    }
                  </script>
                  <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

	<!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
  <script>
  $(document).ready(function() {
      <?php include 'hdo-notif-scripts.php'?>
  });
  </script>

</body>

</html>
