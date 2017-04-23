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

    <body>
        <div class="header">
            <ul>
                <li style="float:left"><a href="" ><font size="4"><b>Class</b>Connect</font></a></li>
                <li style="float:right"><a href="../index.php"><font size="3">Logout</font></a></li>
            </ul>
            
        </div>

        <br>
        <br>

        <div class="container">
            <!-- display all classes enrolled in -->
            <div class="row">
            <div class="col-med-6" style="float: left">
            <div id="classesRow">
               
                 <h4 style="text-align:center"><b>CLASSES</b></h4> 
              
                 <p align="center">
                 <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addClass" >Add Class</a>
                 </p>
            </div>                  
            </div> <!--col-->

            <div class="col-med-6" style="float:right">
            <!-- display all classes enrolled in -->
            <div id="groupsRow" class="studyGroups">
             
                <h4 style="text-align:center"><b>STUDY GROUPS</b></h4>
                
                   <p style="text-align:center">
           
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createGroup" style="margin-right: 7px;">Create a Study Group</a>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addGroup" >Join a Study Group</a>
                
                    </p>
            </div>
            </div> <!--col-->
       </div> <!--row-->

      <div id="times">
            <!-- display available times -->
            <div id="groupsRow" class="row">
                <div class="col-sm-12">
                
                    <div class="row">
                        <div style="text-align:center"><h4><b>AVAILABLE TIMES</b></h4></div>
                    </div>                    
                    <hr>
                    <div class="text-center">
                        <table id="availableTimesTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <div style="text-align:center">
                            <div class="btn-group" role="group">
                                <button id="addAvailableTime" class="btn btn-primary" style="padding: 5px">Add Available Time</button>
                            </div>
                        </div>

                        <br />
                        <br />
                        <!-- have in center under table -->
                        <div class="row">
                        <div id="scheduleSave" style="align: center" hidden>
                                <button onclick="saveAvailableTimes();" class="btn btn-success">save</button>
                                <button onclick="getAvailableTimes();"  class="btn btn-default">cancel</button>
               
                        </div>
                        </div>
                    </div>
                </div>
             </div>
         </div>
     
        
    </body>

    <br />
    <br />  
    <footer class="footer">
		<div class="container" style="text-align:center;">
			<a href="doc.html">F.A.Q. Page</a>
		</div>
	</footer>
</html>

<!-- add class modal -->
<div class="modal fade" id="addClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Class</h5>
      </div>
      <div class="modal-body">
        <!-- form group for dropdown to show classes -->
        <div class="form-group row">
            <label class="col-2 col-form-label">Class</label>
            <!-- can get select value using .val() -->
            <select id="classSelected" class="selectpicker form-control" data-live-search="true" data-live-search-style="startsWith">
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" onclick="addClass();" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- add group modal -->
<div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Group</h5>
      </div>
      <div class="modal-body">
        <!-- form group for dropdown to show classes -->
        <div class="form-group row">
            <label class="form-label">Class</label>
            <!-- can get select value using .val() -->
            <select id="classGroupSelected" class="selectpicker form-control" data-live-search="true" data-live-search-style="startsWith">
            </select>
        </div>
        <!-- form group for dropdown to show groups -->
        <div class="form-group row">
            <label class="form-label">Group</label>
            <!-- can get select value using .val() -->
            <select id="groupSelected" class="selectpicker form-control" data-live-search="true" data-live-search-style="startsWith">
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" onclick="addGroup();" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- create group modal -->
<div class="modal fade" id="createGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Group</h5>
      </div>
      <div class="modal-body">
         <!-- form group for dropdown to show classes -->
        <div class="form-group row">
            <label class="form-label">Class</label>
            <!-- can get select value using .val() -->
            <select id="classSelectedGroupCreate" class="selectpicker form-control" data-live-search="true" data-live-search-style="startsWith">
            </select>
        </div>
        <!-- form to get group name -->
        <div class="form-group row">
            <label class="form-label">Study Group Name</label>
            <!-- can get select value using .val() -->
            <input id="groupName" class="form-control" type="text">
            </select>
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
// fetch account data after page loads
$(document).ready(function() {
    // get classes and groups in
    getEnrolledClasses();
    getEnrolledGroups();
    getAvailableTimes();
    getClasses();
    // fetch groups after select class
    $('#classSelectedGroupCreate').change(function() {
        getGroups($('#classSelectedGroupCreate').val());
    });
    $('#classGroupSelected').change(function() {
        getGroups($('#classGroupSelected').val());
    });
});


// create new row in table
$('#addAvailableTime').click(function() {
    $('#availableTimesTable tbody').append('<tr id="0"><td>'+
        '<select name="dayChoice" style="max-width:200px;" class="form-control">'+
        '<option value="0">Sunday</option><option value="1">Monday</option><option value="2">Tuesday</option>'+
        '<option value="3">Wednesday</option><option value="4">Thursday</option><option value="5">Friday</option>'+
        '<option value="6">Saturday</option></select></td><td>'+
        '<input name="startTime" style="max-width:100px;" class="form-control" type="text" value="00:01"></td><td>'+
        '<input name="endTime" style="max-width:100px;" class="form-control" type="text" value="24:00"></td></tr>');
        $('#scheduleSave').show()
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
            // iterate through classes
            $.each(response, function(index, item) {
                // insert into dropdown list
                $('#classGroupSelected').append('<option value="'+item["classId"]+'">'+item["className"]+'</option>');
                $('#classSelectedGroupCreate').append('<option value="'+item["classId"]+'">'+item["className"]+'</option>');
                
                // insert into classesRow
                $('#classesRow').append('<div class="col-sm-4">'+
                        '<div class="panel panel-primary">'+
                        '<div class="panel-body">'+
                        '<button type="button" onclick="goToClass('+item["classId"]+
                        ',\'' + item["className"] +'\');" class="btn btn-primary">'+item["className"]+
                        '</button></div></div></div>');
            });
            $("#classGroupSelected").selectpicker("refresh");
            $("#classSelectedGroupCreate").selectpicker("refresh");
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
            // iterate through classes
            $.each(response, function(index, item) {
                // insert into classesRow
                $('#groupsRow').append('<div class="col-sm-4">'+
                        '<div class="panel panel-primary">'+
                        '<div class="panel-body">'+
                        '<button type="button" onclick="goToGroup('+item["groupId"]+', \''+
                        item["groupName"] + '\');" class="btn btn-primary">'+item["groupName"]+
                        '</button></div></div></div>');
            });
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

// get general data from server
function getClasses() {
    $.ajax({
        url: '../4_14_2017_doran.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'viewClasses'
        },
        success: function(response) {
            console.log(JSON.stringify(response));
            $('#classSelected').empty();
            $.each(response, function(index, item) {
                // insert into dropdown list
                $('#classSelected').append('<option value="'+item["classId"]+'">'+item["className"]+
                ' - '+item["professor"]+'</option>');
            });
            $("#classSelected").selectpicker("refresh");           
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
            $('#groupSelected').empty();
            $.each(response, function(index, item) {
                $('#groupSelected').append('<option value="'+item["groupId"]+'">'+item["groupName"]+'</option>');
            });
            $("#groupSelected").selectpicker("refresh"); 
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

// functions to call to add or create crap
function addClass() {
    $.ajax({
        url: '../4_14_2017_doran.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'addClass',
            classId: $('#classSelected').val()
        },
        success: function(response) {
            console.log(JSON.stringify(response));
            location.reload();
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function addGroup() {
    $.ajax({
        url: '../4_14_2017_doran.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'addGroup',
            groupId: $('#groupSelected').val()
        },
        success: function(response) {
            console.log(JSON.stringify(response));
            location.reload();
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function createGroup() {
    $.ajax({
        url: '../4_14_2017_doran.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'createGroup',
            classId: $('#classSelectedGroupCreate').val(),
            groupName: $('#groupName').val()
        },
        success: function(response) {
            console.log(JSON.stringify(response));
            location.reload();
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function getAvailableTimes() {
    $.ajax({
        url: '../4_14_2017_groups.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'getTimesAvailable'
        },
        success: function(response) {
            console.log(JSON.stringify(response));
            counter = 0;
            $('#availableTimesTable tbody').empty();
            $.each(response, function(index, item) {
                $('#availableTimesTable tbody').append('<tr id="'+item["id"]+'"><td>'+
        '<select id="dayChoice'+counter+'" name="dayChoice" style="max-width:200px;" class="form-control">'+
        '<option value="0">Sunday</option><option value="1">Monday</option><option value="2">Tuesday</option>'+
        '<option value="3">Wednesday</option><option value="4">Thursday</option><option value="5">Friday</option>'+
        '<option value="6">Saturday</option></select></td><td>'+
        '<input name="startTime" style="max-width:100px;" class="form-control" type="text" value="'+item["startTime"]+'"></td><td>'+
        '<input name="endTime" style="max-width:100px;" class="form-control" type="text" value="'+item["endTime"]+'"></td></tr>');
            $('#dayChoice'+(counter)).val(item["dayId"]);
            counter++;
            });
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function saveAvailableTimes() {
    var timesAvailable = new Array();
    $.each($('#availableTimesTable tbody').children(), function(index, item) { 
        var id = item.id;
        var dayId = $($(item).find("td").eq(0)).children().val();
        var startTime = $($(item).find("td").eq(1)).children().val();
        var endTime = $($(item).find("td").eq(2)).children().val();
        timesAvailable[timesAvailable.length] = {id: id, dayId: dayId, startTime: startTime, endTime: endTime};
    });
    // ajax time
    $.ajax({
        url: '../4_14_2017_groups.php', // need to write function to handle redirects to new pages
        method: 'POST',
        data: {
            action: "setTimesAvailable",
            timesAvailable: timesAvailable
        },
        sucess: function(response) {
            console.log(JSON.stringify(response));
            getAvailableTimes();
            alert("Save Successful!");
        },
        error: function(response) {
            alert('ERROR:' + JSON.stringify(response));
        }
    });
}

function goToClass(desiredClass, desiredClassName) {
    console.log(desiredClass);
    location = "../html/class.php?classId=" + desiredClass + "&className='" + desiredClassName + "'";
}

function goToGroup(desiredGroup, desiredGroupName) {
    console.log(desiredGroup);
    location = "../html/group.php?groupId=" + desiredGroup + "&groupName='" + desiredGroupName + "'";
}
</script>