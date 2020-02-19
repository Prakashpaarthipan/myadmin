<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
//$client = new MongoDB\Driver\Manager('mongodb://172.16.50.149:27017/');
$client = new MongoDB\Driver\Manager( 'mongodb://172.16.50.149:27017/db?gssapiserviceName=mongodb' ); // connect to a remote host at a given port
//$client = new MongoDB\Driver\Manager('mongodb://172.16.50.149:27017/db?gssapiserviceName=mongodb');
//mongodb://172.16.50.149:27017/db?gssapiserviceName=mongodb
//mongodb://172.16.50.149:27017/db?gssapiserviceName=mongodb
var_dump($client);
$db = $client->executeCommand('test',new MongoDB\Driver\Command(['ping' => 1]));


//$db = $client->$JewelTrace_V1;

var_dump($db);
$collections = $db->listCollections();
var_dump($collections);
*/
/*

// connect to mongodb
$manager = new MongoDB\Driver\Manager('mongodb://172.16.50.149:27017/');

$command = new MongoDB\Driver\Command(array("ping" => 1));
$result = $manager->executeCommand("test", $command);

var_dump($result, $result->toArray());

*/
// connect to mongodb
//print_r(get_declared_classes());
$manager = new MongoDB\Driver\Manager('mongodb://172.16.50.149:27017/db');

var_dump(get_class_methods($manager));
var_dump(get_object_vars($manager));

$command = new MongoDB\Driver\Command(['ping' => 1]);

try {
    $cursor = $manager->executeCommand('admin', $command);
} catch(MongoDB\Driver\Exception $e) {
    echo $e->getMessage(), "\n";
    exit;
}
$response = $cursor->toArray()[0];

var_dump($response);
var_dump(get_object_vars($collections));
var_dump($collections);
foreach ($collections as $collection) {
    echo "amount of documents in $collection: ";
    echo $collection->count(), "\n";
}
?>
Something is wrong with the XAMPP installation :-(
