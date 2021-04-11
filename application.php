<?php
/* mysqli connection params */
global $mysqli;
require_once('classes/database/Database.php');
$db = Database::getInstance();
$mysqli = $db->getConnection();


function run_query(){
    if (!isset($mysqli)) {
        return false;
    }
}