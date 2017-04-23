<?php
/* handles all the logic for:
    1) view classes
    2) view groups
    3) enroll in class
    4) enroll in group
    5) create group
 */
 session_start();

//$_SESSION['accountId'] = 1;
// DATABASE INFO
define(DSN, "mysql:host=localhost;dbname=classconnect;port=3307");
define(DBUSER, "root");
define(DBPASS, "root");

header("content-type:application/json");
// accountId is saved in $_SESSION

// always get action to check what function want to call
$action = $_POST['action'];

if($action == "viewClasses") {
    echo json_encode(viewClasses());
} else if($action == "addClass") {
    echo json_encode(addClass());
} else if($action == "viewGroups") {
    echo json_encode(viewGroups());
} else if($action == "addGroup") {
    echo json_encode(addGroup());
} else if($action == "createGroup") {
    echo json_encode(createGroup());
}

// returns all classes that are active, <GOOD>
function viewClasses() {
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getClassesInfo()");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// enroll in class, <GOOD>
function addClass() {
    $accountId = $_SESSION['accountId'];
    $classId = $_POST['classId'];
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL enrollInClass(?, ?)");
    $stmt->bindValue(1, $accountId, PDO::PARAM_INT);
    $stmt->bindValue(2, $classId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// view all groups for a certain class, <GOOD>
function viewGroups() {
    $classId = $_POST['classId'];
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getClassGroups(?)");
    $stmt->bindValue(1, $classId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// enroll in group, <GOOD>
function addGroup() {
    $accountId = $_SESSION['accountId'];
    $groupId = $_POST['groupId'];
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL enrollInGroup(?, ?)");
    $stmt->bindValue(1, $accountId, PDO::PARAM_INT);
    $stmt->bindValue(2, $groupId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// create new group for a class, <GOOD>
function createGroup() {
    $accountId = $_SESSION['accountId'];
    $groupName = $_POST['groupName'];
    $classId = $_POST['classId'];
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL createGroup(?, ?, ?)");
    $stmt->bindValue(1, $accountId, PDO::PARAM_INT);
    $stmt->bindValue(2, $groupName, PDO::PARAM_STR);
    $stmt->bindValue(3, $classId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

?>