<?php
/* handles all the logic for:
    1) login
    2) register
    3) updateAccountInfo
    4) logout
 */
session_start();
// DATABASE INFO
define(DSN, "mysql:host=localhost;dbname=classconnect;port=3307");
define(DBUSER, "root");
define(DBPASS, "root");


// accountId is saved in $_SESSION

// always get action to check what function want to call
$action = $_POST['action'];

if($action == "login") {
    echo json_encode(login());
} else if($action == "register") {
    echo json_encode(register());
} else if($action == "updateAccountInfo") {
    echo json_encode(updateAccountInfo());
} else if($action == "logout") {
    echo json_encode(logout());
}

// verify if user has an account, if has an account then 
// start session and return true, else return false, <GOOD>
function login() {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("SELECT isValidUserAccount(?, ?)");
    $stmt->bindValue(1, $username, PDO::PARAM_INT);
    $stmt->bindValue(2, $password, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $id = $result[0][key($result[0])];
    

    // create session if login successful
    if(0 < $id) {
        session_start();
        $_SESSION['accountId'] = $id;
        
        $stmt = $db->prepare("SELECT getAccountUsername(?)");
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['accountName'] = $result[0][key($result[0])];
        
        $stmt = $db->prepare("SELECT getAccountEmail(?)");
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['accountEmail'] = $result[0][key($result[0])];

        $db = NULL;
        return array('result' => true);
    }
    $db = NULL;
    return array('result' => false); // invalid account
}

// create an account, <GOOD>
function register() {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $type = 1; // not sure if should have 1: normal user, 2: teacher

    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL createAccount(?, ?, ?, ?)");
    $stmt->bindValue(1, $username, PDO::PARAM_INT);
    $stmt->bindValue(2, $password, PDO::PARAM_INT);
    $stmt->bindValue(3, $name, PDO::PARAM_INT);
    $stmt->bindValue(4, $type, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = NULL;
    session_start();
    $_SESSION['accountId'] = $result[0][key($result[0])];
    $_SESSION['accountName'] = $name;
    $_SESSION['accountEmail'] = $username;

    return array('result' => (0 < $result[0][key($result[0])]));
}

// change user's password, <GOOD>
function changePassword() {
    $accountId = $_SESSION['acountId'];
    $password = $_POST['password'];

    $db = new PDO(DSN, DBUSER, DBPASS);
    $stmt = $db->prepare("CALL modifyAccount(?, ?)");
    $stmt->bindValue(1, $accountId, PDO::PARAM_INT);
    $stmt->bindValue(2, $password, PDO::PARAM_INT);
    $stmt->execute();
    $db = NULL;
    return array('result' => 'successful');
}

function logout() {
    session_destroy();
    return array('result' => "successful");
}

?>