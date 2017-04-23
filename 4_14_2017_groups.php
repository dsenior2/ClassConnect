<?php
/* handles all the logic for:
    1) view group messages
    2) add group message
    3) create study session
    4) add self to study session
    5) add times available
    6) get times available
    7) view study sessions
 */
session_start();
// DATABASE INFO
define(DSN, "mysql:host=localhost;dbname=classconnect;port=3307");
define(DBUSER, "root");
define(DBPASS, "root");


// accountId is saved in $_SESSION

// always get action to check what function want to call
$action = $_POST['action'];

if($action == "viewGroupMessage") {
    echo json_encode(viewGroupMessages());
} else if($action == "addGroupMessage") {
    echo json_encode(addGroupMessage());
} else if($action == "createStudySession") {
    echo json_encode(createStudySession());
} else if($action == "enrollInStudySession") {
    echo json_encode(enrollInStudySession());
} else if($action == "setTimesAvailable") {
    echo json_encode(setTimesAvailable());
} else if($action == "getTimesAvailable") {
    echo json_encode(getTimesAvailable());
} else if($action == "getStudySessions") {
    echo json_encode(getStudySessions());
} else if($action == "getMemberAvailableTime") {
    echo json_encode(getMemberAvailableTime());
}

function getMemberAvailableTime() {
    $accountId = $_POST['memberId'];

    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getUserAvailableTime(?)");
    $stmt->bindValue(1, $accountId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// view group messages, <GOOD>
function viewGroupMessages() {
    // require groupId
    $groupId = $_POST['groupId'];
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getGroupMessages(?)");
    $stmt->bindValue(1, $groupId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// posted a message in group chat, <GOOD>
function addGroupMessage() {
    // requires
    $groupId = $_POST['groupId'];
    $sentAccountId = $_SESSION['accountId'];
    $messageText = $_POST['messageText'];
    $fileName = $_FILES['file']['name'];
    $isAttachedFiles = isset($fileName);

    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL addGroupMessage(?, ?, ?, ?)");
    $stmt->bindValue(1, $groupId, PDO::PARAM_INT);
    $stmt->bindValue(2, $sentAccountId, PDO::PARAM_INT);
    $stmt->bindValue(3, $messageText, PDO::PARAM_STR);
    $stmt->bindValue(4, $isAttachedFiles, PDO::PARAM_INT);
    $stmt->execute();
    // need to fetch messageId
    if($isAttachedFiles == true) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $messageId = $result[0][key($result[0])];
        $bucketName = '../files/'.$groupId."/".$sentAccountId."/".$messageId."/";
        $db = NULL;
        $db = new PDO(DSN, DBUSER, DBPASS);
        $stmt = $db->prepare("CALL uploadFileGroupMessaging(?, ?, ?, ?, ?)");
        $stmt->bindValue(1, $bucketName, PDO::PARAM_STR);
        $stmt->bindValue(2, $fileName, PDO::PARAM_STR);
        $stmt->bindValue(3, $messageId, PDO::PARAM_INT);
        $stmt->bindValue(4, $groupId, PDO::PARAM_INT);
        $stmt->bindValue(5, $sentAccountId, PDO::PARAM_INT);   
        
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $fileId = $result[0][key($result[0])];
        $db = NULL;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $bucketName.$fileName)) {
            $alert = 1;
        }
    }
    $db = NULL;
    return array('groupId' => $groupId, 'sentAccountId' => $sentAccountId, 'messageText' => $messageText, 'alert' => $alert,
                'isAttachedFiles' => $isAttachedFiles, 'file' => $fileName, 'bucketName' => $bucketName, 'dir' => __DIR__);

}

// create a new study session for group, <GOOD>
function createStudySession() {
    // require
    $accountId = $_SESSION['accountId'];
    $groupId = $_POST['groupId'];
    $location = $_POST['location'];
    $date = $_POST['date']; // format: 2017-12-14 13:20:03
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL createGroupMeeting(?, ?, ?, ?)");
    $stmt->bindValue(1, $groupId, PDO::PARAM_INT);
    $stmt->bindValue(2, $accountId, PDO::PARAM_INT);
    $stmt->bindValue(3, $location, PDO::PARAM_STR);
    // need to cast date to string
    $stmt->bindValue(4, date("Y-m-d H:i:s", strtotime($date)), PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// enroll in already created study session, <GOOD>
function enrollInStudySession() {
    // require
    $accountId = $_SESSION['accountId'];
    $meetingId = $_POST['meetingId'];
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL enrollInGroupMeeting(?, ?)");
    $stmt->bindValue(1, $meetingId, PDO::PARAM_INT);
    $stmt->bindValue(2, $accountId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// get list of all times student is free, <GOOD>
function getTimesAvailable() {
    // require
    $accountId = $_SESSION['accountId'];
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getUserAvailableTime(?)");
    $stmt->bindValue(1, $accountId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// set times free, <GOOD>
function setTimesAvailable() {
    // require
    $accountId = $_SESSION['accountId'];
    $timesAvailable = $_POST['timesAvailable'];
    
    // iterate through each entry said they were available
    foreach ($timesAvailable as $key => $availableEntry) {
        $db = new PDO(DSN, DBUSER, DBPASS);
        $stmt = $db->prepare("CALL saveTimeAvailable(?, ?, ?, ?, ?)");
        $stmt->bindValue(1, $accountId, PDO::PARAM_INT);
        $stmt->bindValue(2, $availableEntry['id'], PDO::PARAM_INT);
        $stmt->bindValue(3, date("Y-m-d H:i:s", strtotime($availableEntry['startTime'])), PDO::PARAM_STR);
        $stmt->bindValue(4, date("Y-m-d H:i:s", strtotime($availableEntry['endTime'])), PDO::PARAM_STR);
        $stmt->bindValue(5, $availableEntry['dayId'], PDO::PARAM_INT);
        $stmt->execute();
        $db = NULL;
    }
    
    return array('result' => 'successful');
}

function getStudySessions() {
    $groupId = $_POST['groupId'];

    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getGroupMeetingsInfo(?)");
    $stmt->bindValue(1, $groupId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

?>