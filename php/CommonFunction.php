<?

$_POST = cleanInputs($_POST);
$_GET = cleanInputs($_GET);

function formatMoney($number, $fractional=false) { 
    if ($fractional) { 
        $number = sprintf('%.2f', $number); 
    } 
    while (true) { 
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
        if ($replaced != $number) { 
            $number = $replaced; 
        } else { 
            break; 
        } 
    } 
    return $number; 
}

/* Get From Session*/
function Get_Email()
{
	if($_SESSION['site_email']=="")
	{
		$_SESSION['site_email'] = GetSiteValues("site_email");
	}
	return $_SESSION['site_email'];
}

function Get_Copy_Right()
{
	if($_SESSION['site_copy_right']=="")
	{
		$_SESSION['site_copy_right'] = GetSiteValues("site_copy_right");
	}
	return $_SESSION['site_copy_right'];
}
function Get_Project_Name()
{
	if($_SESSION['site_project_name']=="")
	{
		$_SESSION['site_project_name'] = GetSiteValues("site_project_name");
	}
	return $_SESSION['site_project_name'];
}
function Get_Url()
{
	if($_SESSION['site_url']=="")
	{
		$_SESSION['site_url'] = GetSiteValues("site_url");
	}
	return $_SESSION['site_url'];
}
function Get_Analytics_Code()
{
	if($_SESSION['analytics_code']=="")
	{
		$_SESSION['analytics_code'] = GetSiteValues("analytics_code");
	}
	return $_SESSION['analytics_code'];
}

function Get_Meta_Title()
{
	if($_SESSION['meta_title']=="")
	{
		$_SESSION['meta_title'] = GetSiteValues("meta_title");
	}
	return $_SESSION['meta_title'];
}
function Get_Meta_Keyword()
{
	if($_SESSION['meta_keyword']=="")
	{
		$_SESSION['meta_keyword'] = GetSiteValues("meta_keyword");
	}
	return $_SESSION['meta_keyword'];
}
function Get_Meta_Description()
{
	if($_SESSION['meta_description']=="")
	{
		$_SESSION['meta_description'] = GetSiteValues("meta_description");
	}
	return $_SESSION['meta_description'];
}
function Get_Phone_Number()
{
	if($_SESSION['site_phone_number']=="")
	{
		$_SESSION['site_phone_number'] = GetSiteValues("site_phone_number");
	}
	return $_SESSION['site_phone_number'];
}
function Get_Fax_Number()
{
	if($_SESSION['site_fax_number']=="")
	{
		$_SESSION['site_fax_number'] = GetSiteValues("site_fax_number");
	}
	return $_SESSION['site_fax_number'];
}
function Get_Facebook_Link()
{
	if($_SESSION['site_facebook_link']=="")
	{
		$_SESSION['site_facebook_link'] = GetSiteValues("site_facebook_link");
	}
	return $_SESSION['site_facebook_link'];
}
function Get_Linkedin_Link()
{
	if($_SESSION['site_linkedin_link']=="")
	{
		$_SESSION['site_linkedin_link'] = GetSiteValues("site_linkedin_link");
	}
	return $_SESSION['site_linkedin_link'];
}
function Get_Google_Plus_Link()
{
	if($_SESSION['site_google_plus_link']=="")
	{
		$_SESSION['site_google_plus_link'] = GetSiteValues("site_google_plus_link");
	}
	return $_SESSION['site_google_plus_link'];
}
function Get_Twitter_Link()
{
	if($_SESSION['site_twitter_link']=="")
	{
		$_SESSION['site_twitter_link'] = GetSiteValues("site_twitter_link");
	}
	return $_SESSION['site_twitter_link'];
}
function Get_Youtube_Link()
{
	if($_SESSION['site_youtube_link']=="")
	{
		$_SESSION['site_youtube_link'] = GetSiteValues("site_youtube_link");
	}
	return $_SESSION['site_youtube_link'];
}
function Near_By_Me_Location()
{
	if($_SESSION['near_by_me']=="")
	{
		$_SESSION['near_by_me'] = GetSiteValues("near_by_me");
	}
	return $_SESSION['near_by_me'];
}
function Get_Site_Logo()
{
	if($_SESSION['nkfd_site_logo']=="")
	{
		$rs_site_logo=mysql_query('SELECT * FROM site_logo');
		$site_logo=mysql_fetch_array($rs_site_logo);
		$_SESSION['nkfd_site_logo'] = $site_logo['site_logo_path'];
	}
	return $_SESSION['nkfd_site_logo'];
}
function GetLocation($lat,$long)
{
	$url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($long).'&sensor=false&key=AIzaSyBSJJItwkFTpH7W5qTiiH0AaBKvf__9ih4';
	$json = @file_get_contents($url);
	$data=json_decode($json);
	$status = $data->status;
	if($status=="OK")
	return $data->results[0]->formatted_address;
	else
	return false;
}

if($_SESSION["check_block_ip"]=="1" || $_SESSION["check_block_ip"]=="")
{

	$sel_qry=mysql_query("select * from block_ip WHERE ip_address='".$_SERVER["REMOTE_ADDR"]."'");
	if(mysql_num_rows($sel_qry) > 0 )
	{
		while($block=mysql_fetch_array($sel_qry))
		{
			$date1=date_create(date('Y-m-d H:i:s'));
			$date2=date_create($block['date']);
			$diff=date_diff($date1,$date2);
			$diffhours=substr($diff->format("%R%h hours"),1);
			$diffdate=substr($diff->format("%R%a days"),1);
			if($diffdate==0 && $diffhours<2)
			{
				header('Location:'.$hack_redirect_url);
			}
		}
	}
	$_SESSION["check_block_ip"]=true;
	
}
// Ck editor
 if(isset($_POST["description"])){ $_POST["description"] =str_replace("../ProjectImages/ContentImage/", "ProjectImages/ContentImage/",$_POST["description"]);}


$main_dir = 'ProjectImages/';
//$uploaddirparent_gallery = '../ProjectImages/Gallery/';

function  getOriginalContent($Content)
{
	return str_replace("ProjectImages/ContentImage/","../ProjectImages/ContentImage/",$Content);
}

function  getOriginalCaseStudy($CaseStudy)
{
	return str_replace("ProjectImages/CaseStudyImage/","../ProjectImages/CaseStudyImage/",$CaseStudy);
}

function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}
 function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
 function get_request_method()
 {
			return $_SERVER['REQUEST_METHOD'];
}
function GetshortString($str,$len)
{
	if(strlen($str) > $len)
	{
	 	$stringval = substr($str, 0, $len)."...";
	}
	else
	{
		$stringval=$str;
	}
	return $stringval;
}

function GetValue($table,$field,$where,$condition)
 {
	$sql_result=mysql_query("SELECT $field from $table where $where='$condition'");
	if(mysql_affected_rows()>0)
	{
		$row=mysql_fetch_array($sql_result);
		return $row[$field];
	}
	else
	{
		return "";
	}
 }
function CountByTable($table,$where)
{
	
		if($table=='content')
		{
			 $sql_result = mysql_query("SELECT count(*) as total FROM $table where is_deleted=0");
			
		}
		else if($table=='menu')
		{
			$sql_result = mysql_query("SELECT count(*) as total FROM content where is_deleted=0 AND $where");
		}
		else 
		{
			
			 $sql_result = mysql_query("SELECT count(*)  as total FROM $table $where"); //where is_active=1
		}
	/*	else
		{
			 $sql_result = mysql_query("SELECT * FROM $table where CreateDate between date_sub(now(),INTERVAL 1 WEEK) and now()");
		}*/
	$result= mysql_fetch_array($sql_result);
	return $result["total"];
}

function strEncode($str)
{
	return strtolower(str_replace(" ","-",$str));
}

function GetSiteValues($key)
{
	return  GetValue("site_setting","value","site_key",$key);
} 

function encrypt($pure_string) {
  $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
 
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $pure_string, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
}

/**
 * Returns decrypted original string
 */
function decrypt($encrypted_string) {
  $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $encrypted_string ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}
 function generatePassword($length = 8) {
        $possibleChars = "abcdefghijklmnopqrstuvwxyz";
        $password = '';

        for($i = 0; $i < $length; $i++) {
            $rand = rand(0, strlen($possibleChars) - 1);
            $password .= substr($possibleChars, $rand, 1);
        }

        return $password;
    }
	 
	function cleanInputs($data)
	{
		  include "BlacklistKeyword.php"; 
		 $clean_input = array();
			if(is_array($data)){
				
				//code start for insert record in history table
			/*	if(!empty($data) && !array_key_exists("msg",$data) && !array_key_exists("id",$data) && !array_key_exists("data_ids",$data) && !array_key_exists("module",$data))
				{
					$ins_qry="insert into history_table(request_data,ip_address,method,date)values('";
					foreach($data as $k => $v){
						if($v!="")
						{
							$ins_qry.=$k.'=>'.$v.'  ';
						}
						
					}
					$ins_qry.="','".$_SERVER["REMOTE_ADDR"]."','".$_SERVER['REQUEST_METHOD']."','".date('Y-m-d H:i:s')."')";

					$res_ins=mysql_query($ins_qry);
				}//code end for insert record in history table
				*/
				foreach($data as $k => $v){
					
					if(is_array($v))
					{
						foreach($v as $kk=>$vv)
						{
							$clean_input[$k][$kk] = mysql_real_escape_string($vv);
							/*foreach ($block_lists as $key => $word) 
						{
								
								if (strpos($vv, $word) !== FALSE) 
								{
									$sql_insert_ip="insert into block_ip(ip_address,date,reason)
									values('".$_SERVER["REMOTE_ADDR"]."','".date('Y-m-d H:i:s')."','hack conten')";
									mysql_query($sql_insert_ip);
									
										$subject    = 'hack content'; 
										$message    = ("Ip Addres:".$_SERVER["REMOTE_ADDR"]); 
										$to   		= $master_admin_email;//replace with your email
										$headers   = array();
										$headers[] = "MIME-Version: 1.0";
										$headers[] = "Content-type: text/plain; charset=iso-8859-1";
										$headers[] = "From: {$name} <{".GetSiteValues('site_email')."}>";
										$headers[] = "Reply-To: <{".GetSiteValues('site_email')."}>";
										$headers[] = "Subject: {$subject}";
										$headers[] = "X-Mailer: PHP/".phpversion();
										
										mail($to, $subject, $message, $headers);
									
									header('Location:'.$hack_redirect_url);
									return false;
								}
								
						}*///code end for block user if hack keyword enter
						}
					}
					else
					{
						$clean_input[$k] = mysql_real_escape_string($v);
						/*foreach ($block_lists as $key => $word) 
						{
								
								if (strpos($v, $word) !== FALSE) 
								{
									$sql_insert_ip="insert into block_ip(ip_address,date,reason)
									values('".$_SERVER["REMOTE_ADDR"]."','".date('Y-m-d H:i:s')."','hack conten')";
									mysql_query($sql_insert_ip);
									
										$subject    = 'hack content'; 
										$message    = ("Ip Addres:".$_SERVER["REMOTE_ADDR"]); 
										$to   		= $master_admin_email;//replace with your email
										$headers   = array();
										$headers[] = "MIME-Version: 1.0";
										$headers[] = "Content-type: text/plain; charset=iso-8859-1";
										$headers[] = "From: {$name} <{".GetSiteValues('site_email')."}>";
										$headers[] = "Reply-To: <{".GetSiteValues('site_email')."}>";
										$headers[] = "Subject: {$subject}";
										$headers[] = "X-Mailer: PHP/".phpversion();
										
										mail($to, $subject, $message, $headers);
									
									header('Location:'.$hack_redirect_url);
									return false;
								}
								
						}*///code end for block user if hack keyword enter
					}
				
				}
				
				
				
			}else{
				if(get_magic_quotes_gpc()){
					$data = trim(stripslashes($data));
				}
				$data = strip_tags($data);
				$clean_input = trim($data);
			}
			
			return $clean_input;
		}	
		
		
		
		
		if (!function_exists('getallheaders')) 
{ 
   function getallheaders() 
    { 
	
         $headers = ''; 
       foreach ($_SERVER as $name => $value) 
       { 
           if (substr($name, 0, 5) == 'HTTP_') 
           { 
		   	
               $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
           } 
       } 
	 
       return $headers; 
    } 
}

function createdirectory($path)
{
	$mkdirpermission='0777';
	$mkdirtrue='true';
	mkdir($path, $mkdirpermission, $mkdirtrue);
}
function nFormatter($num) {
	 if ($num >= 1000000000) {
		return ($num / 1000000000).round ().str_replace(.0.'$', '').'G';
	 }
	 if ($num >= 1000000) {
		return ($num / 1000000).round ().str_replace(.0.'$', '').'M';
	 }
	 if ($num >= 1000) {
		return ($num / 1000).round ().str_replace(.0.'$', '').'K';
	 }
	 return $num;
}

?>