<?php

/**
 * Config!
 */

/* API */
// Make sure to use the proxy connection
$config = array();
$config['ethernet_client_proxy'] = array();
$config['ethernet_client_proxy']['key'] = 'A6356CC7C0CB58B12B2B76EE3DD65A6B';

/* Pins */

// Digital
$dPinLedStatus = 11;
$dPinServoPower = 3;
$dPinServoAngle = 5;
$dPinFire = 6;

// Init the teleduino object
require_once('teleduino328.php');

?>