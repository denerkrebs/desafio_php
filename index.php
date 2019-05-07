<?php

require __DIR__ . '/config/db.php';

// get database connection
$database = new Database();
$db = $database->getConnection();