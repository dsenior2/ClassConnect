<?php
/* handles all the logic for:
    1) see people in class
    2) see people in group
    3) leave class
    4) leave group
    5) send email
    6) view files in class
    7) view files in group
    8) view students enrolled classes 
    9) view students enrolled groups
 */
session_start();
// $_SESSION['accountId'] = 1;
// DATABASE INFO
define(DSN, "mysql:host=localhost;dbname=classconnect;port=3307");
define(DBUSER, "root");
define(DBPASS, "root");

// accountId is saved in $_SESSION

// always get action to check what function want to call
$action = $_POST['action'];

if($action == "viewStudentsInClass") {
    echo json_encode(viewStudentsInClass());
} else if($action == "viewStudentsInGroup") {
    echo json_encode(viewStudentsInGroup());
} else if($action == "leaveClass") {
    echo json_encode(leaveClass());
} else if($action == "leaveGroup") {
    echo json_encode(leaveGroup());
} else if($action == "sendEmail") {
    echo json_encode(sendEmail());
} else if($action == "viewGroupFiles") {
    echo json_encode(viewGroupFiles());
} else if($action == "viewClassFiles") {
    echo json_encode(viewClassFiles());
} else if($action == "viewEnrolledClasses") {
    echo json_encode(viewEnrolledClasses());
} else if($action == "viewEnrolledGroups") {
    echo json_encode(viewEnrolledGroups());
}

// fetch all the names of people enrolled in selected class, <GOOD>
function viewStudentsInClass() {
    $classId = $_POST['classId'];
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getStudentsInClass(?)");
    $stmt->bindValue(1, $classId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// fetch all the names of people enrolled in selected group, <GOOD>
function viewStudentsInGroup() {
    $groupId = $_POST['groupId'];
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getStudentsInGroup(?)");
    $stmt->bindValue(1, $groupId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// remove self from class, <GOOD>
function leaveClass() {
    $accountId = $_SESSION['accountId'];
    $classId = $_POST['classId'];
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL leaveClass(?, ?)");
    $stmt->bindValue(1, $accountId, PDO::PARAM_INT);
    $stmt->bindValue(2, $classId, PDO::PARAM_INT);
    $stmt->execute();
    $db = NULL;
    return array('result' => "successful");
}

// remove self from group, <GOOD>
function leaveGroup() {
    $accountId = $_SESSION['accountId'];
    $groupId = $_POST['groupId'];
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL leaveGroup(?, ?)");
    $stmt->bindValue(1, $accountId, PDO::PARAM_INT);
    $stmt->bindValue(2, $groupId, PDO::PARAM_INT);
    $stmt->execute();
    $db = NULL;
    return array('result' => "successful");
}

// send an email to listed recipient(s)
// NOTE: Windows doesn;t provide the smtp server 
// to send emails.  need to setup on Linux
function sendEmail() {
    echo "1, ";
    $accountEmail = $_SESSION['accountEmail'];
    $recipient = $_POST['recipient'];
    $message = $_POST['message'];
    $subject = $_POST['subject'];

    // use wordwrap() if lines are longer than 70 characters
    //$message = wordwrap($message, 70);
    $header = "From: ".$accountEmail;
    echo "2, ";
    // to, subject, message, headers, parameters
    sendEmail($recipient, $subject, $message, $headers);
    echo "3";
    return array('result' => "successful");
}

// return all files uploaded in class, <GOOD>
function viewClassFiles() {
    $groupId = 0;
    $messageId = $_POST['messageId'];
    $classId = $_POST['classId'];

    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getUploadedFiles(?, ?, ?)");
    $stmt->bindValue(1, $messageId, PDO::PARAM_INT);
    $stmt->bindValue(2, $groupId, PDO::PARAM_INT);
    $stmt->bindValue(3, $classId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// return all files uploaded in group discussion, <GOOD>
function viewGroupFiles() {
    $groupId = $_POST['groupId'];
    $messageId = $_POST['messageId'];
    $classId = 0;

    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getUploadedFiles(?, ?, ?)");
    $stmt->bindValue(1, $messageId, PDO::PARAM_INT);
    $stmt->bindValue(2, $groupId, PDO::PARAM_INT);
    $stmt->bindValue(3, $classId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// return all classes enrolled in
function viewEnrolledClasses() {
    $accountId = $_SESSION['accountId'];

    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getEnrolledClasses(?)");
    $stmt->bindValue(1, $accountId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// return all groups enrolled in
function viewEnrolledGroups() {
    $accountId = $_SESSION['accountId'];

    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getEnrolledGroups(?)");
    $stmt->bindValue(1, $accountId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

?>