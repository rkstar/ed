<?php
//
// appconfig.php
// written by: David Fudge [rkstar@mac.com]
// created on: September 24, 2012
// updated on: September 24, 2012
//
// this is the only config file to be included by ed based php applications.
// from here we will include the rest of our config files and
// start our ed app.


/////// app filepath config ////////////////

// url/domain for this application
define("DOMAIN",	"xc.local");
define("URL",		"http://".DOMAIN);

// system path to the root dir
define("APPDIR",	realpath(dirname(__FILE__)."/../../"));	// this is used to include all other files

// library files path
define("LIBDIR",	APPDIR."/ed/lib");	// realpath() to the ed library files


/////// app database config ////////////////

// below we'll define all the data needed to connect to a
// database that will be used on our site.
define("DB_TYPE",	"MYSQL");
define("DB_HOST",	"localhost");
define("DB_USER",	"local_dbuser");
define("DB_PASS",	'bestpasswordever');	// NOTE: single quotes here because of special chars possibility
define("DB_NAME",	"local_database_name");
// DSN is used for PDO
define("PDO_DSN",	strtolower(DB_TYPE).":host=".DB_HOST.";dbname=".DB_NAME);
// NOTE: mysql has a flag called old_passwords that makes the PASSWORD() function return
// strings encrypted with the mysql 3.x hashing.  if we want/need to override that, we
// can do so here.  i recommend leaving this set to TRUE because there should be
// nobody using mysql 3.x anymore!
//
// allow us to easily force old mysql passwords.  if we do not force old passwords,
// we WILL FORCE new passwords.  make sure you set this variable appropriately.
define("FORCE_OLD_MYSQL_PASSWORDS",	false);
// below are definitions for automatically updated fields
// in your database.  you can update "last modified" and "ip address" fields.
// these fields will be updated with the current datetime and ip address values
// each time a record in your databse table is modified.
//
// set up default auto-update field names
define("LASTMODIFIED",	"lastmodified");
define("IPADDRESS",		"ipaddress");


/////// app email send config ///////////////////

// the following data will be used for sending notification emails from your site
define("NOTIFICATION_EMAIL_FROM_ADDRESS",	"notifications@localhost");
define("NOTIFICATION_EMAIL_FROM_NAME",		"localhost");
define("NOTIFICATION_EMAIL_HOST",			"localhost");
define("NOTIFICATION_EMAIL_PORT",			25);	// default mail port
define("NOTIFICATION_EMAIL_PRIORITY",		3);		// normal priority


/////// app customization config ////////////////

// custom configuration data will be included every time
// we put this last so that we will never overwrite any of our
// previously defined constants.  if you choose a constant name that
// is already in use, please choose another.
include_once(dirname(__FILE__)."/custom.php");


///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
//                                                       //
//                                                       //
//////////////   D O   N O T   M O D I F Y   //////////////
//                                                       //
//                                                       //
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////

// we want to include our setup file here
// after this file is included, we will be able
// to use our __require() function to include our
// various API packages into our application(s)
require_once(LIBDIR."/ed.php");
?>