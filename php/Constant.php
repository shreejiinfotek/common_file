<?
define("HEADER_KEY_NAME", "Appsecret");
define("HEADER_KEY","9f9a9c475379aa0ff9a2294a0fe5911ac0dd839b6fd96af25a942f1a44325612");
define("UPDATEDDATE",date("Y-m-d"));
define("MAIL_ENABLE", true);
define("SUPER_ADMIN_ENABLE", false);
define("BANNERSIZE", "(900px W * 400px H)");
define("SMALLSIZE", "(150px W * 60px H)");
define("MEDIUMSIZE", "(400px W * 175px H)");
define("LARGESIZE", "(900px W * 400px H)");
define("GALLERY_SMALL_IMAGE_HEIGHT", "200");
define("GALLERY_SMALL_IMAGE_WIDTH", "300");
define("GALLERY_MEDIUM_IMAGE_HEIGHT", "600");
define("GALLERY_MEDIUM_IMAGE_WIDTH", "900");
define("GALLERY_DISPLAY", "(600px W * 400px H)");

define("PROPERTY_SMALL_IMAGE_HEIGHT", "200");
define("PROPERTY_SMALL_IMAGE_WIDTH", "300");
define("PROPERTY_MEDIUM_IMAGE_HEIGHT", "600");
define("PROPERTY_MEDIUM_IMAGE_WIDTH", "900");


define("TESTIMONIALSIZE","(100px W * 100px H)");
define("CHANGE_PROFILE","(100px W * 100px H)");
define("PRODUCT_CATEGORY","(200px W * 200px H)");
define("PRODUCT_CATEGORY_DISPLAY","100px");
define("USER_PROFILE","100px");
define("TESTIMONIAL_WIDTH","100");
define("PAGINATION",5);
$hack_redirect_url="http://".$_SERVER["SERVER_NAME"]."/nkfdcalgary/access_denied.php";
$master_admin_email="vaibhav.kothia@gmail.com";
$name="Notify";





if($_SERVER['HTTP_HOST']=="localhost")
{
	
	define("DB_SERVER", "win");
	define("DB_USER", "root");
	define("DB_PASSWORD", "#win123");
	define("DB", "newmark");

}
else
{	
	define("DB_SERVER", "localhost");
	define("DB_USER", "nkfdca_nkfd");
	define("DB_PASSWORD", "nypivgGONcZ0");
	define("DB", "nkfdca_nkfd");

}

?>