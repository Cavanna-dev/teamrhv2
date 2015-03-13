<?php

/** CONSTANTES **/
define('CONST_PROJECT_NAME'  , 'TeamRH');
define('CONST_HOST'          , 'localhost');
define('CONST_SALT_PRE'      , 'aze123wxc456');
define('CONST_SALT_SUF'      , '987poi321mlk');
define('CONST_DATABASE_NAME' , 'teamrh_dev');
define('CONST_DATABASE_USER' , 'root');
define('CONST_DATABASE_PWD'  , '');
define('CONST_URI'           , $_SERVER['DOCUMENT_ROOT'] . '\\' . CONST_PROJECT_NAME);


try {
    $db = new PDO('mysql:host=' . CONST_HOST . ';dbname=' . CONST_DATABASE_NAME, CONST_DATABASE_USER, CONST_DATABASE_PWD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>