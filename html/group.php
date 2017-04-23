<html>
    <head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- select live search -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css" />

        <style>
            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: #778899;
            }

            li {
                float: left;
                border-right:1px solid #bbb;
            }

            li:last-child {
                border-right: none;
            }

            li a {
                display: block;
                color: white;
                text-align: center;
                padding: 10px 12px;
                text-decoration: none;
            }

            li a:hover:not(.active) {
                background-color: #DCDCDC;
            }

            .active {
                background-color: #DCDCDC;
            }
        </style>
    </head>

    <body>

        <div class="header">
            <ul>
                <li style="float:left"><a href="../html/home.php" ><font size="4"><b>Class</b>Connect</font></a></li>
                <li style="float:right"><a href="../html/logout.php"><font size="3">Logout</font></a></li>
            </ul>
            
        </div>
        <br>
        <br>

        <div class="container">
            <div class="col-md-12">
            <div id="infoRow" class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Group Members</div>
                        <div class="panel-body">
                            <table id="membersTable" class="table">
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div>
                                Meetings
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createMeeting" style="float: right;">create meeting</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="meetingsTable" class="table">
                                <thead>
                                    <tr>
                                        <th>Location</th>
                                        <th>Meet Time</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>                                         
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Files</div>
                        <div class="panel-body">
                            <table id="filesTable" class="table">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">File Name</th>
                                        <th class="col-md-2">Uploaded By</th>
                                        <th class="col-md-1">Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>                                
            </div>

            <br>
            <br>
            <br>
            <br>
            <br>

            <!-- display all classes enrolled in -->
            <div id="messagingRow" class="row">
                <div class="col-sm-12">
                    <!-- show messages -->
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="text-center">Messages</h1>
                            <hr>
                            <div id="messages" class="list-group" style="max-height:50%; overflow-y: scroll">

                            </div>                            
                        </div>
                        
                    </div>
                    <!-- write messages -->
                    <div class="row">
                        <div class="col-sm-10">
                            <!-- input area -->
                            <textarea id="groupChatMessage" class="form-control" style="height: inherit;width: inherit;" placeholder="message"></textarea>
                        </div>
                        <div class="col-sm-2">
                            <div class="btn-group-vertical" style="float: right;">
                                
                                <!-- file -->
                                <label class="btn btn-default btn-file">
                                    Browse <input type="file" name='file' style="display: none;">
                                </label>
                                <!-- submit -->
                                <button type="submit" onclick="postMessage();" class="btn btn-sm btn-primary">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>                    
                    <br>
                </div>
            </div>
            </div>
        </div>
    </body>
</html>

<!-- create meeting modal -->
<div class="modal fade" id="memberAvailableTime" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="memberNameHeader"></h5>
      </div>
      <div class="modal-body">
        <table id="memberAvailableTimesTable" class="table">
            <thead>
                <tr>
                    <th class="col-md-2">Day</th>
                    <th class="col-md-1">Start Time</th>
                    <th class="col-md-1">End Time</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- create meeting modal -->
<div class="modal fade" id="createMeeting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Meeting</h5>
      </div>
      <div class="modal-body">
         <!-- form group for dropdown to show classes -->
        <div class="form-group row">
            <label class="form-label">Location</label>
            <!-- can get select value using .val() -->
            <input id="meetingLocation" class="form-control" type="text">
        </div>
        <!-- form to get group name -->
        <div class="form-group row">
            <label class="form-label">Time</label>
            <!-- can get select value using .val() -->
            <input id="meetingTime" class="form-control" type="datetime-local">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" onclick="createGroup();" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<script>
    var groupId = <?php echo $_GET['groupId']; ?>;
    var groupName = <?php echo $_GET['groupName']; ?>;
    var isFileAttached = false;
    var files = null;
// fetch account data after page loads
$(document).ready(function() {
    // get classes and groups in
    getEnrolledClasses();
    getEnrolledGroups();
    viewGroupFiles(0);
    getGroupMembers();
    getMeetings();
    getMessages();
});

// listeners
$('input[type=file]').on('change', function(event) {
    files = event.target.files;
    debugger;
});

// functions to call get data about user from server
function getEnrolledClasses() {
    $.ajax({
        url: '../4_15_2017_class.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'viewEnrolledClasses'
        },
        success: function(response) {
            console.log(JSON.stringify(response));
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function getEnrolledGroups() {
    $.ajax({
        url: '../4_15_2017_class.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'viewEnrolledGroups',
        },
        success: function(response) {
            console.log(JSON.stringify(response));
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function getGroupMembers() {
	$.ajax({
		url: '../4_15_2017_class.php',
		type: 'POST',
		dataType: 'json',
		data: {
			action: 'viewStudentsInGroup',
			groupId: groupId
		},
		success: function(response) {
			console.log(JSON.stringify(response));
            $.each(response, function(index, item) {
                $('#membersTable tbody').append('<tr onclick="getMemberAvailableTime('+item["id"]+', \''+item["name"]+'\');"><td>'+item["name"]+'</td><td>'+item["email"]+'</td></tr>');
            });
		},
		error: function(response) {
			alert('ERROR:' + JSON.stringify(response));
		}
	});
}

function viewGroupFiles(messageId) {
	$.ajax({
		url: '../4_15_2017_class.php',
		type: 'POST',
		dataType: 'json',
		data: {
			action: 'viewGroupFiles',
			groupId: groupId,
			messageId: messageId
		},
		success: function(response) {
			console.log(JSON.stringify(response));
            $('#filesTable tbody').empty();
            $.each(response, function(index, item) {
                $('#filesTable tbody').append('<tr><td><a href="'+item["url"]+'" target="_blank">'+
                item["fileName"]+'</a></td><td>'+item["uploadedBy"]+'</td><td>'+item["uploadDate"]+'</td></tr>');
            });
		},
		error: function(response) {
			alert('ERROR:' + JSON.stringify(response));
		}
	});
}

function getMeetings() {
	$.ajax({
		url: '../4_14_2017_groups.php',
		type: 'POST',
		dataType: 'json',
		data: {
			action: 'getStudySessions',
			groupId: groupId
		},
		success: function(response) {
			console.log(JSON.stringify(response));
            $('#meetingsTable tbody').empty();
            $.each(response, function(index, item) {
                $('#meetingsTable tbody').append('<tr><td>'+item["location"]+
                '</td><td>'+item["meetTime"]+'</td><td>'+item["createdBy"]+'</td></tr>');
            });
		},
		error: function(response) {
			alert('ERROR:' + JSON.stringify(response));
		}
	});    
}

function getMessages() {
	$.ajax({
		url: '../4_14_2017_groups.php',
		type: 'POST',
		dataType: 'json',
		data: {
			action: 'viewGroupMessage',
			groupId: groupId
		},
		success: function(response) {
			console.log(JSON.stringify(response));
            $('#messages').empty();
            $.each(response, function(index, item) {
                if(item['isAttachedFiles'] == 1) {
                    $('#messages').append('<div class="list-group-item list-group-item-action flex-column align-items-start">'+
                                    '<div class="row"><div class="col-sm-10" style="border-right: 1px solid #ddd;">'+
                                    '<div class="d-flex justify-content-between"><h5 class="mb-1">'+item["by"]+'</h5>'+
                                    '<small>'+item["createDate"]+'</small></div><p class="mb-1">'+item["messageText"]+
                                    '</small></div><div class="col-sm-2"><div class="d-flex justify-content-between">'+
                                    '<h5 class="mb-1">'+item["fileName"]+'</h5><small><a href="'+item["url"]+'" target="_blank">'+
                                    'preview</a></small><br><small><a href="'+item["url"]+'">downoad</a></small></div></div></div></div>');

                } else {
                    $('#messages').append('<div class="list-group-item list-group-item-action flex-column align-items-start">'+
                                                '<div class="row"><div class="col-sm-12">'+
                                                '<div class="d-flex justify-content-between"><h5 class="mb-1">'+
                                                item["by"]+'</h5><small>'+item["createDate"]+'</small></div>'+
                                                '<p class="mb-1">'+item["messageText"]+'</p></div></div></div>');
                }

            });
            $("#messages").scrollTop($("#messages")[0].scrollHeight);
		},
		error: function(response) {
			alert('ERROR:' + JSON.stringify(response));
		}
	});
}

function postMessage() {
    var messageText = $('#groupChatMessage').val();
    
    var form_data = new FormData();
    form_data.append('action', 'addGroupMessage');
    form_data.append('groupId', groupId);
    form_data.append('messageText', messageText);
    form_data.append('file', (files == null ? null : files[0]));

	$.ajax({
		url: '../4_14_2017_groups.php',
		type: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        enctype:'multipart/form-data',
		dataType: 'json',
		data: form_data,
		success: function(response) {
			console.log(JSON.stringify(response));
            isFileAttached = false;
            files = null;
            viewGroupFiles(0);
            $('#groupChatMessage').val('');
            getMessages();
		},
		error: function(response) {
			alert('ERROR:' + JSON.stringify(response));
		}
	});
}

function createGroup() {
    var location = "";
    var time = "";
    
    // ajax call
    $.ajax({
        url: '../4_14_2017_groups.php',
        method: 'POST',
        data: {
            action: 'createStudySession',
            groupId: groupId,
            location: $('#meetingLocation').val(),
            date: $('#meetingTime').val()
        },
        dataType: 'json',
        success: function(response) {
            console.log("good");
            getMeetings();
            $('#createMeeting').modal('toggle');
        }
    });
}

function getMemberAvailableTime(id, name) {
    $.ajax({
        url: '../4_14_2017_groups.php',
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'getMemberAvailableTime',
            memberId: id
        },
        success: function(response) {
			console.log(JSON.stringify(response));
            var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday',
                        'Thursday', 'Friday', 'Saturday'];
            $('#memberAvailableTimesTable tbody').empty();
            $.each(response, function(index, item) {
                var day = days[item["dayId"]];

                 $('#memberAvailableTimesTable tbody').append('<tr><td>'+
                 day+'</td><td>'+item["startTime"]+'</td><td>'+item["endTime"]+'</td></tr>');
            });
            $('#memberNameHeader').text('Available Times: ' + name);
            $('#memberAvailableTime').modal('toggle');
        },
        error: function(response) {
			alert(JSON.stringify(response));
        }
    });

}
</script>