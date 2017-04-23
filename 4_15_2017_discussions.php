<?php
/* handles all the logic for discussions:
    1) see discussions
    2) see posts in a discussion
    3) create discussion
    4) post to discussion
    5) reply to discussion post
 */
session_start();
// DATABASE INFO
define(DSN, "mysql:host=localhost;dbname=classconnect;port=3307");
define(DBUSER, "root");
define(DBPASS, "root");

// accountId is saved in $_SESSION

// always get action to check what function want to call
$action = $_POST['action'];

if($action == "viewDiscussions") {
    echo json_encode(viewDiscussions());
} else if($action == "viewDiscussionPosts") {
    echo json_encode(viewDiscussionPosts());
} else if($action == "createDiscussion") {
    echo json_encode(createDiscussion());
} else if($action == "postToDiscussion") {
    echo json_encode(postToDiscussion());
} else if($action == "replyToDiscussion") {
    echo json_encode(replyToDiscussion());
}


// fetches all class discussions, gets name, title, 
// person started, & date, <GOOD>
function viewDiscussions() {
    $classId = $_POST['classId'];
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getClassDiscussions(?)");
    $stmt->bindValue(1, $classId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// get all posts in a discussion, <GOOD>
function viewDiscussionPosts() {
    $discussionId = $_POST['discussionId'];
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL getDiscussionPosts(?)");
    $stmt->bindValue(1, $discussionId, PDO::PARAM_INT);
    $stmt->execute();
    // get discusiion post info
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    // get posts
    $stmt->nextRowset();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return array('rootData' => $results, 'posts' => $posts);
}

// create a discussion, <GOOD>
function createDiscussion() {
    $accountId = $_SESSION['accountId'];
    $title = $_POST['title'];
    $text = $_POST['text'];
    $classId = $_POST['classId'];
    
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL createDiscussion(?, ?, ?, ?)");
    $stmt->bindValue(1, $accountId, PDO::PARAM_INT);
    $stmt->bindValue(2, $classId, PDO::PARAM_INT);
    $stmt->bindValue(3, $title, PDO::PARAM_STR);
    $stmt->bindValue(4, $text, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    return $results;
}

// add post to a the discussion, <GOOD>
function postToDiscussion() {
    $accountId = $_SESSION['accountId'];
    $discussionId = $_POST['discussionId'];
    $classId = $_POST['classId'];
    $text = $_POST['text'];
    $fileName = $_FILES['file']['name'];
    $isAttachedFiles = isset($fileName);
    
    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL addDiscussionPost(?, ?, ?, ?, ?);");
    $stmt->bindValue(1, $discussionId, PDO::PARAM_INT);
    $stmt->bindValue(2, $accountId, PDO::PARAM_INT);
    $stmt->bindValue(3, $classId, PDO::PARAM_INT);
    $stmt->bindValue(4, $text, PDO::PARAM_STR);
    $stmt->bindValue(5, $isAttachedFiles, PDO::PARAM_INT);
    $stmt->execute();
    // need to fetch messageId
    if($isAttachedFiles == true) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $messageId = $result[0][key($result[0])];
        $bucketName = "../files/class".$classId."/".$accountId."/".$messageId."/";
        $db = NULL;
        $db = new PDO(DSN, DBUSER, DBPASS);
        $stmt = $db->prepare("CALL uploadFileClassMessaging(?, ?, ?, ?, ?);");
        $stmt->bindValue(1, $bucketName, PDO::PARAM_STR);
        $stmt->bindValue(2, $fileName, PDO::PARAM_STR);
        $stmt->bindValue(3, $messageId, PDO::PARAM_INT);
        $stmt->bindValue(4, $classId, PDO::PARAM_INT);
        $stmt->bindValue(5, $accountId, PDO::PARAM_INT);
        $stmt->execute();
        $bN = $bucketName;
        $fN = $fileName;
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        move_uploaded_file($_FILES['file']['tmp_name'], $bucketName.$fileName);
    }
    $db = NULL;
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return array('results' => true);
}

?>