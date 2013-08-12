<?php
/**
 * Let's control a couple servos 
 * 
 * RANGE INFO
 * ==========
 * APPLICABLE RANGES:
 * angle: 160-100
 * power: 130-110
 *
 * URL structure:
 * api.php?&method[&actions]
 */
 
$totalTime = microtime(true);
 
/*** Load config **************************************************************/
define('API_DIRECTORY', ROOT_DIRECTORY . '/api');
 
header('Content-Type: application/json');
require_once(API_DIRECTORY . '/config/config.php');
 
/*** Run the desired method ***************************************************/
if (isset($_GET['method'])) {
  $method = $_GET['method'];
} else {
  // Method was not set
  showError(403, 'ERROR. Please select a method.');
}
 
if (isset($_GET['hash']) && strlen($_GET['hash']) == 32) {
  $hash = $_GET['hash'];
} else {
  $hash = false;
}
 
// Create the Teleduino object
require_once(API_DIRECTORY . '/lib/teleduino/teleduino328.php');
$teleduino = new Teleduino328();  // Construct a new teleduino
 
// Set the proxy
$teleduino->setModeEthernetClientProxy($config['ethernet_client_proxy']);
 
// Test and make sure that the connection works
$ping = $teleduino->ping();
if ($ping['result'] != 1) {
  showError(403, 'ERROR. Could not connect to bot.');
}
 
// Define servos
$servoPower = $teleduino->defineServo($config['servoPowerId'], $config['dPinServoPower']);
$servoAngle = $teleduino->defineServo($config['servoAngleId'], $config['dPinServoAngle']);
 
/* Available methods */
 
// Lock method: set servos
if ($method == 'lock') {
  if (isset($_GET['power']) || isset($_GET['angle'])) {
 
    if (authUser($hash)) {
 
      // Set the Power servo
      if (isset($_GET['power'])) {
        $powerVal = intval($_GET['power']);
        if ($powerVal <= $config['servoPowerValMin'] && $powerVal >= $config['servoPowerValMax']) { // Sanitize to prevent physical damage
          $powerServoPosition = $teleduino->setServo($config['servoPowerId'], $powerVal);
        } else {
          showError(403, 'ERROR. Power value is out of range');
        }
      }
 
      // Set the Angle servo
      if (isset($_GET['angle'])) {
        $angleVal = intval($_GET['angle']);
        if ($angleVal <= $config['servoAngleValMin'] && $angleVal >= $config['servoAngleValMax']) { // Sanitize to prevent physical damage
          $angleServoPosition = $teleduino->setServo($config['servoAngleId'], $angleVal);
        } else {
          showError(403, 'ERROR. Angle value is out of range');
        }
      }
 
    } else {
      showError(403, 'Invalid user.');
    }
 
  } else {
    showError(403, 'ERROR. You need to specify values to lock.');
  }
}
 
// Fire method
// @description
else if ($method == 'fire') {
  if (authUser($hash)) {
    $teleduino->togglePwm($config['dPinFire'], 1);
  } else {
    showError(403, 'Invalid user.');
  }
}
 
// Unsupported method
else {
  showError(403, 'ERROR. Invalid method');
}
 
// If nothing fails, show that the script was sucessful
showSuccess(200, round((microtime(true) - $totalTime) * 1000));
 
// Private
 
function authUser($hash) {
  global $mysql;
  if ($hash != false) {
    $DB = new mysqli($mysql['host'], $mysql['user'], $mysql['pass'], $mysql['db']);
 
    if ($DB->connect_error) {
      showError(500, 'Could not connect to the DB.');
    }
 
    $sql = "SELECT person.pid, hash FROM queue JOIN person ON queue.pid = person.pid ORDER BY time LIMIT 1";
    $result = $DB->query($sql);
    $result = $result->fetch_object();
 
    if (empty($result)) {
      showError(500, 'Could not find any users in the queue.');
      return false;
    } else {
      if (strval($result->hash) == $hash) {
        return true; // Does match
      } else {
        return false; // Does not match
      }
    }
  } else {
    showError(403, 'Could not find user.');
    return false;
  }
}
 
// Show status
function showSuccess ($code, $completed_in) {
  echo '{"status":'. $code . ', "completed_in":' . $completed_in . '}';
}
function showError ($code, $message) {
  die('{"status":'. $code . ', "message":"' . $message. '"}');
}
 
 
?>
