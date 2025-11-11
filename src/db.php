<?php
// Minimal PDO connection - edit credentials below
define('DB_HOST','127.0.0.1');
define('DB_NAME','student_events');
define('DB_USER','root');
define('DB_PASS','');

function getPDO(){
    static $pdo = null;
    if ($pdo) return $pdo;
    $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4';
    try{
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
        return $pdo;
    }catch(PDOException $e){
        die('DB connect error: '.$e->getMessage());
    }
}
