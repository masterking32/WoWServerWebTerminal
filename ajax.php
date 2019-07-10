<?php
/**
 * @author       Amin Mahmoudi (MasterkinG)
 * @copyright    Copyright (c) 2019 - 2022, MsaterkinG32 Team, Inc. (https://masterking32.com)
 * @link         https://masterking32.com
 * @Github       https://github.com/masterking32/wow-telegram
 * @Description  It's not masterking32 framework !
 */

include 'config.php';
if (empty($_SESSION["CM_Login"])) {
    echo "Need to login!";
    exit();
}
if (empty($_POST['command'])) {
    echo "Command is not valid !";
    exit();
}
$result = 'No have result!';
try {
    $conn = new SoapClient(NULL, array(
        'location' => 'http://' . $soap_connection_info['soap_host'] . ':' . $soap_connection_info['soap_port'] . '/',
        'uri' => $soap_connection_info['soap_uri'],
        'style' => SOAP_RPC,
        'login' => $soap_connection_info['soap_username'],
        'password' => $soap_connection_info['soap_password']
    ));
    $result = $conn->executeCommand(new SoapParam($_POST['command'], 'command'));
    unset($conn);
} catch (Exception $e) {
    if (!empty(Debug_Mode)) {
        $result = $e;
    } else {
        $result = 'Have error on soap!';
    }
    if (strpos($e, 'There is no such command') !== false) {
        $result = 'There is no such command!';
    }
}
echo $result;