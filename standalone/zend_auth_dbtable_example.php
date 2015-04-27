<?php
// From inside the VM:
//	1. Create a directory /var/www/test
//	2. Link to the ZF files
//		ln -s /usr/local/zend/share/ZendFramework/library/Zend /var/www/test/Zend
//	3. Create this file in /var/www/test/test.php
//	4. Run test program as http://localhost/test/test.php

require "Zend/Auth/Adapter/DbTable.php";
require "Zend/Db/Adapter/Pdo/Sqlite.php";

// Create an in-memory SQLite database connection
$dbAdapter = new Zend_Db_Adapter_Pdo_Sqlite(array('dbname' =>
                                                  ':memory:'));

// Build a simple table creation query
$sqlCreate = 'CREATE TABLE [users] ('
           . '[id] INTEGER  NOT NULL PRIMARY KEY, '
           . '[username] VARCHAR(50) UNIQUE NOT NULL, '
           . '[password] VARCHAR(32) NULL, '
           . '[real_name] VARCHAR(150) NULL)';

// Create the authentication credentials table
$dbAdapter->query($sqlCreate);

// Build a query to insert a row for which authentication may succeed
$sqlInsert = "INSERT INTO users (username, password, real_name) "
           . "VALUES ('my_username', 'my_password', 'My Real Name')";

// Insert the data
$dbAdapter->query($sqlInsert);

// Verify results
$sql = 'SELECT * FROM users';
var_dump($dbAdapter->fetchAll($sql));

// Insert the remaining code from example
// http://framework.zend.com/manual/en/zend.auth.adapter.dbtable.html
