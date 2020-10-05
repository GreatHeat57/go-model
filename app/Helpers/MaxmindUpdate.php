<?php
namespace App\Helpers;
// the download URL for Maxmind database file
DEFINE ('FROM_URL', 'https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key='.config('geoip.maxmind.license_key').'&suffix=tar.gz');  //see article

// the directory location on your site where the Maxmind mmdb file should be installed:
DEFINE ('MY_MAXMIND_DATA_DIR',config('geoip.maxmind.database_path')); // see article; 
// settings needed for notification of the result of update 
DEFINE ('ADMIN_EMAIL_ADDRESS',config('app.admin_email')); // your email address
DEFINE ('THIS_SITE', config('app.url')); // domain name of site (for use in notification email)
DEFINE ('NOTIFICATION_MODE', 2); // 1 = email, 2 = screen + email, 3 = screen

use PharData;
use Illuminate\Support\Facades\Mail;

class MaxmindUpdate {
	protected $max_v2download_url = FROM_URL;
	protected $v2_gz = '';
	protected $v2_tar = '';
	protected $v2_mmdb = '';
	protected $uploadedFile = '';
	protected $mmdbFile ='';
	protected $max_status = '';
 

  public function __construct() {
    // $this->v2_gz = basename(FROM_URL);
    $this->v2_gz = basename('GeoLite2-City.tar.gz');
    $this->v2_tar = pathinfo($this->v2_gz, PATHINFO_FILENAME );
    $this->v2_mmdb = pathinfo($this->v2_tar, PATHINFO_FILENAME ) . '.mmdb';
	$this->uploadedFile = MY_MAXMIND_DATA_DIR . $this->v2_gz;
	$this->mmdbFile = MY_MAXMIND_DATA_DIR . $this->v2_mmdb;
  }


  // main method to upload Maxmind file and update site's maxmind data file
  public function save_maxmind() {
	  $result = 'Failure: ';
	  $status = 0;
	  $error_prefix = 'Warning; unable to update the Maxmind mmdb data file:<br>';
	  $error_suffix = '<br>If a previously installed valid Maxmind look-up file exists then it will continue to be used.';

//if (  $this->dirCreated(MY_MAXMIND_DATA_DIR)  && $this->gztarExtractMax()): // for testing when tar.gz already uploaded to your server
    if (  $this->dirCreated(MY_MAXMIND_DATA_DIR) && $this->upload_max_gzfile() && $this->gztarExtractMax() ):
        $result = 'Success: ';
    	$status = 1;
        $error_prefix = '';
        $error_suffix = '';
        @unlink(MY_MAXMIND_DATA_DIR . $this->v2_gz);  // some gz's are massive so delete as no longer needed
        @unlink(MY_MAXMIND_DATA_DIR . $this->v2_tar);  // some tars are massive so delete as no longer needed
    endif;

    $subject = $result . 'update of ' . $this->v2_mmdb . ' at ' . THIS_SITE;
	$headers = 'From: ' . basename(__FILE__) . '@' . THIS_SITE;

	//send email only on failure
    if($status == 0 && NOTIFICATION_MODE < 3){
    	Mail::send('emails.maxmindupdate', array('subject' => $subject), function ($m) {
            $m->to(ADMIN_EMAIL_ADDRESS)->subject('Maxmind DB udpate on '.THIS_SITE);
        });
    }
    
    if (NOTIFICATION_MODE > 1) echo $subject . '<br /> ' . PHP_EOL . $this->max_status;

  }  // END save_maxmind_data() 


  // return permissions of a directory or file as a 4 character "octal" string
  protected function return_permissions($item) {
    clearstatcache(true, $item);
    $item_perms = @fileperms($item);
  	return empty($item_perms) ? '' : substr(sprintf('%o', $item_perms), -4);	
  }


  // create the site's Maxmind directory if it does not already exist
  protected function dirCreated($theDir){
    if ( ! file_exists($theDir) ){ 
      // then this is the first download, or a new directory location has been defined
      $dir_perms = 0755;  // usual dir perms on shared server
      $item_perms = $this->return_permissions(dirname(__FILE__)); // check folder perms of this script, if 775 assume should apply to Maxmind dir
      if (strlen($item_perms) == 4 && substr($item_perms, 2, 1) == '7') $dir_perms = 0775;
    	if ( ! @mkdir($theDir, $dir_perms, true) ) {
    	   $this->max_status = 'ERROR: Unable to create directory "' . $theDir . '" This may be due to your server permission settings.';
				 return FALSE;
			}
    }
	  return TRUE;
  }
	

  protected function backupMax($fileToBack){
    $fileToBack . '.bak';
    if (! file_exists($fileToBack) || filesize($fileToBack) < 800000 ) return TRUE;
		if (! @copy($fileToBack, $fileToBack . '.bak' ) ):
		  $this->max_status = 'Unable to back-up old Maxmind data - update halted. ';
		  return FALSE;
		endif;
    return TRUE;
  }


  protected function revertToOld($fileToRecover){
    $theBackup = $fileToRecover . '.bak';
    if (! file_exists($theBackup) || filesize($theBackup) < 800000 || ! @copy($theBackup, $fileToRecover) ) :
	  $this->max_status .= "<br>NOTE: unable to revert to a previous version of the data file.";
      return FALSE;
	endif;
	$this->max_status .= '<br>It looks like we were able to revert to an old copy of the file.<br>';
	return TRUE;
  }



  // extract from gzip and untar to folder
  public function gztarExtractMax() {

    // decompress from gz
		@unlink(MY_MAXMIND_DATA_DIR . $this->v2_tar); // phar unzip does not overwrite existing files and would fail
    try {
      $gz = new PharData($this->uploadedFile);
      $gz->decompress(); // extracts tar to same dir
// @unlink(MY_MAXMIND_DATA_DIR . $this->v2_gz);  // if you are approaching disk capacity uncomment for early delete
    } catch (Exception $e) {
        $this->max_status =   "Error uncompressing tar.gz: " . $e->getMessage();  // handle errors
    	return FALSE;
    }

    // unarchive from the tar
    try {
      $archive = new PharData(MY_MAXMIND_DATA_DIR . $this->v2_tar);
      $archive->extractTo(MY_MAXMIND_DATA_DIR);
    } catch (Exception $e) {
        $this->max_status = "Unable to open tar.gz or Tar archive: " . $e->getMessage();
    	return FALSE;
    }

    try {
      foreach ($archive as $entry) :
        $tarFolder = basename($entry);
        $extractDir = MY_MAXMIND_DATA_DIR . $tarFolder;
      endforeach;
      $archive->extractTo(MY_MAXMIND_DATA_DIR, $tarFolder . '/' . $this->v2_mmdb  ,TRUE);
    } catch (Exception $e) {
        $this->max_status =   "Error extracting mmdb from tar archive: " . $e->getMessage();
    	$this->remove_maxtemp_dir($tarFolder);
    	return FALSE;
    }
    $archive->extractTo(MY_MAXMIND_DATA_DIR, array($tarFolder . '/LICENSE.txt', $tarFolder . '/COPYRIGHT.txt')  ,TRUE);
// @unlink(MY_MAXMIND_DATA_DIR . $this->v2_tar);  // if you are approaching disk capacity uncomment for early delete


    // Copy files to folder we actually want, then remove unwanted sub-directory & contents
    if ( ! empty($tarFolder) && $tarFolder != '/' && $tarFolder != "\\" ):  // then files extracted to subdir - copy to parent
      if (! $this->backupMax($this->mmdbFile) ) :
		$this->max_status =  "Unable to back-up old Maxmind mmdb file; update abandoned";
        $this->remove_maxtemp_dir($tarFolder);
        return FALSE;
      endif;

      if (! copy($extractDir . '/' . $this->v2_mmdb, $this->mmdbFile) ) :
      	$this->max_status =  "Error copying Maxmind mmdb file to directory";
		$this->revertToOld($this->mmdbFile);
    	$this->remove_maxtemp_dir($tarFolder);
        return FALSE;
      endif;
      clearstatcache(true, $this->mmdbFile);
      @rename($extractDir . '/README.txt', MY_MAXMIND_DATA_DIR . 'README.txt');
      @rename($extractDir . '/LICENSE.txt', MY_MAXMIND_DATA_DIR . 'LICENSE.txt');
      @rename($extractDir . '/COPYRIGHT.txt', MY_MAXMIND_DATA_DIR . 'COPYRIGHT.txt');
    endif;
    $this->remove_maxtemp_dir($tarFolder);

    clearstatcache(true, $this->mmdbFile);
    if(filesize($this->mmdbFile) < 1) :
      $recoveryStatus = $this->revertToOld($extractedFile);
      $this->max_status =  'Failed to create a valid Maxmind data file - it appears to be empty. Trying to revert to old version: ' . $recoveryStatus;
      return FALSE;
    endif;
		
	$this->max_status =  'Last Maxmind data update successful';
    return TRUE;

  } // gztarExtractMax()



  //  Get the "gzip" from Maxmind's site
  protected function upload_max_gzfile() {

    // open file on server for overwrite by CURL
    if (! $fh = fopen($this->uploadedFile, 'wb')) :
  		$this->max_status = "Failed to fopen " . $this->uploadedFile . " for writing: " .  implode(' | ',error_get_last()) . "<br>";
  		return FALSE;
    endif;

    // Get the "file" from Maxmind
    $ch = curl_init($this->max_v2download_url);
    curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);  // identify as error if http status code >= 400
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'a UA string'); // some servers require a non empty or specific UA
    if( !curl_setopt($ch, CURLOPT_FILE, $fh) ):
  		 $this->max_status = 'curl_setopt(CURLOPT_FILE) failed for: "' . $this->uploadedFile . '"<br><br>';
  		 return FALSE;
  	endif;
    curl_exec($ch);
    if(curl_errno($ch) || curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200 ) :
    	fclose($fh);
  		$this->max_status = 'File upload (CURL) error: ' . curl_error($ch) . ' for ' . $this->max_v2download_url . ' (HTTP status ' . curl_getinfo($ch, CURLINFO_HTTP_CODE) . ')';
        curl_close($ch);
  		return FALSE;
    endif;
    curl_close($ch);
    fflush($fh);
    fclose($fh);

    if( filesize($this->uploadedFile) < 1048576 ) :
  		$this->max_status = 'CURL file transfer completed but the file to uncompress is empty, too small, or non-existent. ' . '(' . $this->uploadedFile . ').<br><br>';
      return FALSE;
    endif;

    $this->max_status = 'Maxmind V2 data updated.';
    return TRUE;
  }  // END  upload_max_gzfile()


  protected function remove_maxtemp_dir($tarFolder) {
    if ( ! empty($tarFolder) && $tarFolder != '/' && $tarFolder != "\\" ): // we dont want to del maxdata dir
		$extractDir = MY_MAXMIND_DATA_DIR . $tarFolder;
	    @unlink($extractDir . '/' . $this->v2_mmdb);
	    @unlink($extractDir . '/LICENSE.txt');
	    @unlink($extractDir . '/COPYRIGHT.txt');
        if ( file_exists($extractDir) === TRUE && ! rmdir($extractDir)) : $this->max_status['nb'] = 'Unable to delete temp dir "' . $extractDir . '" after Maxmind update.'; endif;
	endif;
  }

}  // end class

?>