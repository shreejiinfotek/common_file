<?  include "Constant.php"; ?>
<?
	$db_host=DB_SERVER; 					# Host Name 
	$db_user=DB_USER;	 					# User name
	$db_password=DB_PASSWORD;	 					# Password
	$db_database=DB;			# Databasenae	
	
$today = date('mdyHis');
error_reporting(1);

$link = mysql_connect($db_host,$db_user,$db_password);
//mysql_set_charset('utf8', $link);
mysql_select_db($db_database);
$sql_details = array(
	'user' =>$db_user,
	'pass' => $db_password,
	'db'   => $db_database,
	'host' => $db_host
);

function defaultImage()
{
	return "images/default_image.jpg";
}

?>
