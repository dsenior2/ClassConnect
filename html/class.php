<?php ?>
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

        <link rel="stylesheet" type="text/css" href="dist/bootstrap-clockpicker.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/github.min.css">

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

            #classesRow {
                  background-color: lightgrey;
                  width: 500px;
                  height: 300px;
                  padding: 25px;
                  margin: 25px;
            }

             .studyGroups {
                  background-color: lightgrey;
                  width: 500px;
                  height: 300px;
                  padding: 25px;
                  margin: 25px;
            }

            .times {
                background-color: lightgrey;
                width: 500px;
                height: 300px;
                padding: 25px;
                margin: 25px;
            }

        </style>

    </head>

<!--     <body>
        <div class='header'>
            <div class='pull-right'>
                <div class='btn-group'>
                    <a href="../html/logout.php" type='button' class='btn btn-primary'>Logout</a>
                </div>
            </div>
            <a href="../html/home.php" ><h2>Class Connect</h2></a>
        </div> -->
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
            <div id="infoRow" class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Discussion Posts
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createDiscussionPost" style="float: right;">create post</button>
                        </div>
                        <div class="panel-body">
                            <table id="discussionsTable" class="table">
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
                                        <th>File Name</th>
                                        <th>Uploaded By</th>
                                        <th>Date</th>
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

            <!-- show discussion board only when select a discussion -->
            <div id="messagingRow" class="row" hidden>
                <div class="col-sm-12">
                    <!-- show posts -->
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="text-center">Discussion</h1>
                            <hr>
                            <div id="posts" class="list-group" style="max-height:50%; overflow-y: scroll">
                            </div>                            
                        </div>
                        
                    </div>
                    <!-- write posts -->
                    <div class="row">
                        <div class="col-sm-10">
                            <!-- input area -->
                            <textarea id="classPostMessage" class="form-control" style="height: inherit;width: inherit;" placeholder="message"></textarea>
                        </div>
                        <div class="col-sm-2">
                            <div class="btn-group-vertical" style="float: right;">
                                
                                <!-- file -->
                                <label class="btn btn-default btn-file">
                                    Browse <input type="file" name='file' style="display: none;">
                                </label>
                                <!-- submit -->
                                <button type="submit" onclick="addDiscussionPost();" class="btn btn-sm btn-primary">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>                  
                    <br>
                </div>
            </div>
        </div>
    </body>
</html>

<!-- create discussion modal -->
<div class="modal fade" id="createDiscussionPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Group</h5>
      </div>
      <div class="modal-body">
        <!-- form group for dropdown to show classes -->
        <div class="form-group row">
            <label class="form-label">Title</label>
            <!-- can get select value using .val() -->
            <input id="title" class="form-control" type="text">
        </div>
        <!-- form group for dropdown to show groups -->
        <div class="form-group row">
            <label class="form-label">Text</label>
            <!-- can get select value using .val() -->
            <input id="messageText" class="form-control" type="text">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" onclick="createDiscussion();" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>


<script>
var classId = <?php echo $_GET['classId']; ?>;
var className = <?php echo $_GET['className']; ?>;
var isFileAttached = false;
var files = null;
var currentDiscussionId = 0;

// fetch account data after page loads
$(document).ready(function() {
    // get classes and groups in
    getEnrolledGroups();
    getDiscussions();
    viewClassFiles(0);
});

// listeners
$('input[type=file]').on('change', function(event) {
    files = event.target.files;
    debugger;
});

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
            // iterate through classes
            $.each(response, function(index, item) {
                if(item["classId"] == classId)
                // insert into classesRow
                $('#groupsRow').append('<div class="col-sm-4">'+
                        '<div class="panel panel-primary">'+
                        '<div class="panel-body">'+
                        '<button type="button" onclick="goToGroup('+item["groupId"]+','+item["classId"]+
                        ');" class="btn btn-primary">'+item["groupName"]+'</button>'+
                        '</div></div></div>');
            });
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function viewClassFiles(messageId) {
	$.ajax({
		url: '../4_15_2017_class.php',
		type: 'POST',
		dataType: 'json',
		data: {
			action: 'viewClassFiles',
			classId: classId,
			messageId: messageId
		},
		success: function(response) {
			console.log(JSON.stringify(response));
            $.each(response, function(index, item) {
                $('#filesTable tbody').empty();
                $('#filesTable tbody').append('<tr><td><a href="'+item["url"]+'" target="_blank">'+
                item["fileName"]+'</a></td><td>'+item["uploadedBy"]+'</td><td>'+item["uploadDate"]+'</td></tr>');
            });
		},
		error: function(response) {
			alert('ERROR:' + JSON.stringify(response));
		}
	});
}

function getGroups(desiredClass) {
    $.ajax({
        url: '../4_14_2017_doran.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'viewGroups',
            classId: desiredClass
        },
        success: function(response) {
            console.log(JSON.stringify(response));
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function getDiscussions() {
    $.ajax({
        url: '../4_15_2017_discussions.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'viewDiscussions',
            classId: classId
        },
        success: function(response) {
            console.log(JSON.stringify(response));
            $('#discussionsTable tbody').empty();
            $.each(response, function(index, item) {
                $('#discussionsTable tbody').append('<tr onclick="getDiscussionPosts('+item["messageId"]+');"><td>'+item["title"]+
                '</td><td>'+item["message"]+'</td></tr>');
            });
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function getDiscussionPosts(discussionId) {
    console.log(discussionId);
    currentDiscussionId = discussionId;
    $.ajax({
        url: '../4_15_2017_discussions.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'viewDiscussionPosts',
            discussionId: discussionId
        },
        success: function(response) {
            console.log(JSON.stringify(response));
            $('#posts').empty();
            $.each(response['posts'], function(index, item) {
                if(item['isAttachedFiles'] == 1) {
                    $('#posts').append('<div class="list-group-item list-group-item-action flex-column align-items-start">'+
                                    '<div class="row"><div class="col-sm-10" style="border-right: 1px solid #ddd;">'+
                                    '<div class="d-flex justify-content-between"><h5 class="mb-1">'+item["postedBy"]+'</h5>'+
                                    '<small>'+item["postDate"]+'</small></div><p class="mb-1">'+item["text"]+
                                    '</small></div><div class="col-sm-2"><div class="d-flex justify-content-between">'+
                                    '<h5 class="mb-1">'+item["fileName"]+'</h5><small><a href="'+item["url"]+'" target="_blank">'+
                                    'preview</a></small><br><small><a href="'+item["url"]+'">downoad</a></small></div></div></div></div>');

                } else {
                    $('#posts').append('<div class="list-group-item list-group-item-action flex-column align-items-start">'+
                                                '<div class="row"><div class="col-sm-12">'+
                                                '<div class="d-flex justify-content-between"><h5 class="mb-1">'+
                                                item["postedBy"]+'</h5><small>'+item["postDate"]+'</small></div>'+
                                                '<p class="mb-1">'+item["text"]+'</p></div></div></div>');
                }
            });
            $('#messagingRow').show();
            $("#posts").scrollTop($("#posts")[0].scrollHeight);
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function addDiscussionPost() {
    var messageText = $('#classPostMessage').val();
    //debugger;
    var form_data = new FormData();
    form_data.append('action', 'postToDiscussion');
    form_data.append('classId', classId);
    form_data.append('text', messageText);
    form_data.append('file', (files == null ? null : files[0]));
    form_data.append('discussionId', currentDiscussionId);

    $.ajax({
        url: '../4_15_2017_discussions.php',
		type: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        enctype:'multipart/form-data',
        dataType: 'json',
        data: form_data,
        success: function(response) {
            console.log(JSON.stringify(response));
            files = null;
            viewClassFiles(0);
            getDiscussionPosts(currentDiscussionId);
            $('#classPostMessage').val('');
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function createDiscussion() {
    $.ajax({
        url: '../4_15_2017_discussions.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'createDiscussion',
            title: $('#title').val(),
            text: $('#messageText').val(),
            classId: classId
        },
        success: function(response) {
            console.log(JSON.stringify(response));
            getDiscussions();
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function goToClass(desiredClass) {
    console.log(desiredClass);
    
    $.ajax({
        url: 'class.html', // need to write function to handle redirects to new pages
        method: 'POST',
        data: {
            classId: desiredClass
        },
        sucess: function(response) {
            console.log(JSON.stringify(response));
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function goToGroup(desiredGroup, desiredGroupClass) {
    console.log(desiredGroup);
    
    $.ajax({
        url: 'group.html', // need to write function to handle redirects to new pages
        method: 'POST',
        data: {
            classId: desiredClass
        },
        sucess: function(response) {
            console.log(JSON.stringify(response));
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}
</script>