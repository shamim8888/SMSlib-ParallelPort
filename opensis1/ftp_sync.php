<?php
/*
	File : FTP_SYNC.PHP
	Ver. : 1.0.1
	Desc.: The class is made to work as an alternative to rsync when FTP is only available.
		The class use FTP to do synchronization to the target FTP host.
		It copies only the new and modified files after last run of the script.
		You can specify exclude list to the class and any directories or files in this list will be ignored from synchronization.

	Developed By John Saman	(jsaman.59@gmail.com)
	Used and owned by www.ephotobay.com
	Licensed Under Non-Profit Open Software License 3.0 (Non-Profit OSL 3.0)
*/
class FTPSync{

	// set up basic connection
	var $RemoteftpServer;
	var $RemoteftpUsername;
	var $RemoteftpPassword;
        var $LocalftpServer;
	var $LocalftpUsername;
	var $LocalftpPassword;
        
	var $maxConnections;

	var $options;
	var $exclude_list;

	var $RemoteconIds=array();
	var $RemoteconStats=array();
        var $LocalconIds=array();
	var $LocalconStats=array();
        
	var $localFiles=array();
        var $RemoteFiles=array();

	var $verbose=false;

	var $totalFiles=0,$totalSize=0,$transferredFiles=0,$transferredSize=0,$failedSize=0;

	function __construct($RemoteftpServer,$RemoteftpUsername,$RemoteftpPassword,$LocalftpServer,$LocalftpUsername,$LocalftpPassword,$maxConnections=5,$exclude_list='',$options=''){
		ignore_user_abort(true);
		set_time_limit(0);

		//ini_set('display_errors', '1');

		$this->RemoteftpServer=$RemoteftpServer;
		$this->RemoteftpUsername=$RemoteftpUsername;
		$this->RemoteftpPassword=$RemoteftpPassword;
                $this->LocalftpServer=$LocalftpServer;
		$this->LocalftpUsername=$LocalftpUsername;
		$this->LocalftpPassword=$LocalftpPassword;
		$this->maxConnections=$maxConnections;

		$this->options=explode(',',$options);
		$this->exclude_list=explode(',',$exclude_list);

		date_default_timezone_set('America/New_York');

		for($i=0;$i<$this->maxConnections;$i++){
			$this->newStream($i);
		}
	}
	function newStream($i){
		$RemoteconId = ftp_connect($this->RemoteftpServer);
                $LocalconId = ftp_connect($this->LocalftpServer);
		// login with username and password
		$Remotelogin_result = ftp_login($RemoteconId, $this->RemoteftpUsername, $this->RemoteftpPassword);
		// /home/content/61/10367861/html/
                $Locallogin_result = ftp_login($LocalconId, $this->LocalftpUsername, $this->LocalftpPassword);
		// turn passive mode on
		ftp_pasv($RemoteconId, true);
                ftp_pasv($LocalconId, true);
                
                
		$this->RemoteconIds[$i]=$RemoteconId;
                $this->LocalconIds[$i]=$LocalconId;
		$this->localFiles[$i]='';
		$this->RemoteconStats[$i]=FTP_FAILED;//initial value
                $this->LocalconStats[$i]=FTP_FAILED;//initial value
	}
	function __destruct(){
		//upload remaining chunks
		while($this->continueUpload());
                //Download remaining chunks
                while($this->continueDownload());
		for($i=0;$i<$this->maxConnections;$i++){
			ftp_close($this->RemoteconIds[$i]);
                        ftp_close($this->LocalconIds[$i]);
		}

		//display report
		print_r($this);
	}

	function getIdleStreamIndex($persistent=true){
		static $lastIndex=0;

		for($i=$lastIndex;($i+1)%$this->maxConnections!=$lastIndex;$i=($i+1)%$this->maxConnections){
			if($this->RemoteconStats[$i]==FTP_FAILED&&$this->localFiles[$i]==''){
				$lastIndex=($i+1)%$this->maxConnections;

				return $i;
			}
                        if($this->LocalconStats[$i]==FTP_FAILED&&$this->RemoteFiles[$i]==''){
				$lastIndex=($i+1)%$this->maxConnections;

				return $i;
			}
		}
		if($persistent){
			//no idle stream so wait till there is one
			do{
				$this->continueUpload();
                                $this->continueDownload();
			}while(($index=$this->getIdleStreamIndex(false))==-1);

			return $index;
		}else{
			return -1;//there is no empty stream
		}
	}
	function continueUpload(){
		$someThingUploaded=false;
		for($i=0;$i<$this->maxConnections;$i++){
			if($this->RemoteconStats[$i]==FTP_MOREDATA){
			   // Continue upload...
			   $this->RemoteconStats[$i]=ftp_nb_continue($this->RemoteconIds[$i]);
			   $someThingUploaded=true;
			}
			if($this->RemoteconStats[$i]==FTP_FINISHED){

				//ftp_chmod($this->conIds[$i], fileperms ($this->localFiles[$i]) & 0777, $remote.'/'.$entry);

				if($this->verbose){
					echo $this->localFiles[$i]." : done($i).\r\n";
					flush();
				}

				$this->RemoteconStats[$i]=FTP_FAILED;
				$this->localFiles[$i]='';
			}
			if($this->RemoteconStats[$i]==FTP_FAILED&&$this->localFiles[$i]!=''){
				//failed file -- log error
				echo $this->localFiles[$i]." : error($i).\r\n";
				flush();

				$this->localFiles[$i]='';
			}
			//special case of stats inconsistency
			if($this->RemoteconStats[$i]!=FTP_FAILED&&$this->RemoteconStats[$i]!=FTP_MOREDATA&&$this->conStats[$i]!=FTP_FINISHED){
				echo $this->localFiles[$i]." : i_error($i).\r\n";
				flush();
				
				$this->RemoteconStats[$i]=FTP_FAILED;
				$this->localFiles[$i]='';
			}
		}
		return $someThingUploaded;
	}
	function uploadFile($local,$remote){
		//get handle to a connection stream
		$index=$this->getIdleStreamIndex();

		$this->localFiles[$index] = $local;

		//initiate the upload
		$this->RemoteconStats[$index]=ftp_nb_put($this->RemoteconIds[$index], $remote, $local, FTP_BINARY);

		if($this->RemoteconStats[$index]==FTP_FAILED){//disconnected so try to connect
			ftp_close($this->RemoteconIds[$index]);

			$this->newStream($index);

			//try to reupload
			$this->RemoteconStats[$index]=ftp_nb_put($this->RemoteconIds[$index], $remote, $local, FTP_BINARY);
			if($this->RemoteconStats[$index]==FTP_FAILED){//permament failure
				die('Connection Error.'."\r\n");
			}
		}

	}
        
        	function continueDownload(){
		$someThingDownloaded=false;
		for($i=0;$i<$this->maxConnections;$i++){
			if($this->RemoteconStats[$i]==FTP_MOREDATA){
			   // Continue Download...
			   $this->RemoteconStats[$i]=ftp_nb_continue($this->RemoteconIds[$i]);
			   $someThingDownloaded=true;
			}
			if($this->RemoteconStats[$i]==FTP_FINISHED){

				//ftp_chmod($this->conIds[$i], fileperms ($this->localFiles[$i]) & 0777, $remote.'/'.$entry);

				if($this->verbose){
					echo $this->RemoteFiles[$i]." : done($i).\r\n";
					flush();
				}

				$this->RemoteconStats[$i]=FTP_FAILED;
				$this->RemoteFiles[$i]='';
			}
			if($this->RemoteconStats[$i]==FTP_FAILED&&$this->RemoteFiles[$i]!=''){
				//failed file -- log error
				echo $this->RemoteFiles[$i]." : error($i).\r\n";
				flush();

				$this->RemoteFiles[$i]='';
			}
			//special case of stats inconsistency
			if($this->RemoteconStats[$i]!=FTP_FAILED&&$this->RemoteconStats[$i]!=FTP_MOREDATA&&$this->RemoteconStats[$i]!=FTP_FINISHED){
				echo $this->RemoteFiles[$i]." : i_error($i).\r\n";
				flush();
				
				$this->RemoteconStats[$i]=FTP_FAILED;
				$this->RemoteFiles[$i]='';
			}
		}
		return $someThingDownloaded;
	}
        
        
        
        function DownloadFile($remote,$local){
		//get handle to a connection stream
		$index=$this->getIdleStreamIndex();

		$this->RemoteFiles[$index] = $remote;

		//initiate the Download
		$this->RemoteconStats[$index]=ftp_nb_get($this->RemoteconIds[$index], $local, $remote,  FTP_BINARY);

		if($this->RemoteconStats[$index]==FTP_FAILED){//disconnected so try to connect
			ftp_close($this->RemoteconIds[$index]);

			$this->newStream($index);

			//try to redownload
			$this->RemoteconStats[$index]=ftp_nb_get($this->RemoteconIds[$index], $local, $remote,  FTP_BINARY);
			if($this->RemoteconStats[$index]==FTP_FAILED){//permament failure
				die('Connection Error.'."\r\n");
			}
		}

	}
        
        
	function rawListRemote($remote){
		$index=$this->getIdleStreamIndex();

		$raw_files=ftp_rawlist($this->RemoteconIds[$index], $remote);
		if(!is_array($raw_files)){//failed so retry again one more time
			ftp_close($this->RemoteconIds[$index]);

			$this->newStream($index);

			$raw_files=ftp_rawlist($this->RemoteconIds[$index], $remote);
			if(!is_array($raw_files)){//permament failure
				die('Connection Error.'."\r\n");
			}
		}
		return $raw_files;
	}
        
        function rawListLocal($local){
		$index=$this->getIdleStreamIndex();

		$raw_files=ftp_rawlist($this->LocalconIds[$index], $local);
		if(!is_array($raw_files)){//failed so retry again one more time
			ftp_close($this->LocalconIds[$index]);

			$this->newStream($index);

			$raw_files=ftp_rawlist($this->LocalconIds[$index], $local);
			if(!is_array($raw_files)){//permament failure
				die('Connection Error.'."\r\n");
			}
		}
		return $raw_files;
	}
        
        
        
        
        
      //  function rawListLocal($local){
		//$index=$this->getIdleStreamIndex();

	//	$raw_files=scandir($local);
	//	if(!is_array($raw_files)){//failed so retry again one more time
			//ftp_close($this->conIds[$index]);

			//$this->newStream($index);

	//		$raw_files=scandir($local);
	//		if(!is_array($raw_files)){//permament failure
	//			die('Connection Error.'."\r\n");
	//		}
	//	}
	//	return $raw_files;
	//}
        
	function syncRemoteDir($local,$remote,$createDir=true){

		if($createDir){
			//create dir if not existent
			@ftp_mkdir($this->RemoteconIds[$this->getIdleStreamIndex()],$remote);
		}

		//load files list from remote FTP
		$raw_files=$this->rawListRemote($remote);

		$files=array();
		foreach($raw_files as $file){
			$chunks = preg_split("/\s+/", $file);

			if($chunks[1] != 1 && ($chunks[8] == "." || $chunks[8] == "..")){
				// do nothing
			} else {

				list($hour,$minute)=explode(':',$chunks[7]);

				$item['size']=$chunks[4];

				switch(strtolower($chunks[5])){
					case 'jan':$chunks[5]=1;break;
					case 'feb':$chunks[5]=2;break;
					case 'mar':$chunks[5]=3;break;
					case 'apr':$chunks[5]=4;break;
					case 'may':$chunks[5]=5;break;
					case 'jun':$chunks[5]=6;break;
					case 'jul':$chunks[5]=7;break;
					case 'aug':$chunks[5]=8;break;
					case 'sep':$chunks[5]=9;break;
					case 'oct':$chunks[5]=10;break;
					case 'nov':$chunks[5]=11;break;
					case 'dec':$chunks[5]=12;break;
				}
				$item['modify']=mktime($hour,$minute,0,$chunks[5],$chunks[6]);//year is assumed current year
				$item['type'] = $chunks[0]{0} === 'd' ? 'directory' : 'file'; 

				array_splice($chunks, 0, 8);
				$files[implode(" ", $chunks)] = $item; 
			}
		}

		if ($handle = opendir($local)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					$file=@$files[$entry];

					$localFileSize=filesize($local.'/'.$entry);
					$localIsDir=is_dir($local.'/'.$entry);

					if(!$localIsDir){
						$this->totalSize+=$localFileSize;
						$this->totalFiles++;
					}

					if(!empty($file)&&($file['modify']+43200)>=filemtime($local.'/'.$entry)&&$file['size']==$localFileSize&&
					!$localIsDir){
						//do nothing, this is sync. copy
					}else{

						if(in_array($entry,$this->exclude_list)){
							continue;
						}

						if($localIsDir){
							//recurse to sync. directory
							if(empty($file)){
								//if file with the same name as directory it'll fail
								$conId=$this->RemoteconIds[$this->getIdleStreamIndex()];
								@ftp_mkdir($RemoteconId,$remote.'/'.$entry);

								ftp_chmod($RemoteconId, fileperms ($local.'/'.$entry ) & 0777, $remote.'/'.$entry);
							}

							$this->syncRemoteDir($local.'/'.$entry,$remote.'/'.$entry,false);
						}else{
							//if file existent remove it
							if(!empty($file)){
								ftp_delete($this->RemoteconIds[$this->getIdleStreamIndex()],$remote.'/'.$entry);
							}

							//sync. file
							$this->uploadFile($local.'/'.$entry,$remote.'/'.$entry);

							$this->transferredSize+=$localFileSize;
							$this->transferredFiles++;

						}
					}
					$this->continueUpload();//to make a progress in upload queue
				}
			}
			closedir($handle);

			if($this->verbose){
				echo $remote. ' : sync'."\r\n";
				flush();
			}
		}
	}
        
        //Added By Shamim Ahmed Chowdhury for Remote To Local Synchronization
        	function syncLocalDir($remote,$local,$createDir=true){

		if($createDir){
			//create dir if not existent
			@ftp_mkdir($this->LocalconIds[$this->getIdleStreamIndex()],$local);
                        
                               
		}

		//load files list from Local Directory Shamim Ahmed Chowdhury
		$raw_files=$this->rawListLocal($local);

		$localfiles=array();
		foreach($raw_files as $file){
                        //$file_string  = stat($file);
			$chunks = preg_split("/\s+/", $file);

			if($chunks[1] != 1 && ($chunks[8] == "." || $chunks[8] == "..")){
				// do nothing
			} else {

				list($hour,$minute)=explode(':',$chunks[7]);

				$item['size']=$chunks[4];

				switch(strtolower($chunks[5])){
					case 'jan':$chunks[5]=1;break;
					case 'feb':$chunks[5]=2;break;
					case 'mar':$chunks[5]=3;break;
					case 'apr':$chunks[5]=4;break;
					case 'may':$chunks[5]=5;break;
					case 'jun':$chunks[5]=6;break;
					case 'jul':$chunks[5]=7;break;
					case 'aug':$chunks[5]=8;break;
					case 'sep':$chunks[5]=9;break;
					case 'oct':$chunks[5]=10;break;
					case 'nov':$chunks[5]=11;break;
					case 'dec':$chunks[5]=12;break;
				}
				$item['modify']=mktime($hour,$minute,0,$chunks[5],$chunks[6]);//year is assumed current year
				$item['type'] = $chunks[0]{0} === 'd' ? 'directory' : 'file'; 

				array_splice($chunks, 0, 8);
				$localfiles[implode(" ", $chunks)] = $item; 
			}
		}
                
                
                //load files list from remote FTP
		$raw_files=$this->rawListRemote($remote);

		$remotefiles=array();
		foreach($raw_files as $file){
			$chunks = preg_split("/\s+/", $file);

			if($chunks[1] != 1 && ($chunks[8] == "." || $chunks[8] == "..")){
				// do nothing
			} else {

				list($hour,$minute)=explode(':',$chunks[7]);

				$item['size']=$chunks[4];

				switch(strtolower($chunks[5])){
					case 'jan':$chunks[5]=1;break;
					case 'feb':$chunks[5]=2;break;
					case 'mar':$chunks[5]=3;break;
					case 'apr':$chunks[5]=4;break;
					case 'may':$chunks[5]=5;break;
					case 'jun':$chunks[5]=6;break;
					case 'jul':$chunks[5]=7;break;
					case 'aug':$chunks[5]=8;break;
					case 'sep':$chunks[5]=9;break;
					case 'oct':$chunks[5]=10;break;
					case 'nov':$chunks[5]=11;break;
					case 'dec':$chunks[5]=12;break;
				}
				$item['modify']=mktime($hour,$minute,0,$chunks[5],$chunks[6]);//year is assumed current year
				$item['type'] = $chunks[0]{0} === 'd' ? 'directory' : 'file'; 

				array_splice($chunks, 0, 8);
				$remotefiles[implode(" ", $chunks)] = $item; 
			}
		}
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
		//if ($handle = opendir($remote)) {
		$contents = ftp_nlist($this->RemoteconIds[$this->getIdleStreamIndex()], $remote); 	
                //while (false !== ($entry = readdir($handle))) {
                foreach($contents as $entry) { 
                                $entry = str_replace($remote, "", $entry);
                                $entry = substr($entry,1);
				if ($entry != "." && $entry != "..") {
					$file=@$files[$entry];
                                        echo "localfile"+$file;
                                        $remoteFileSize = ftp_size( $this->RemoteconIds[$this->getIdleStreamIndex()], $remote.'/'.$entry );
					//$remoteFileSize=filesize($remote.'/'.$entry);
					
                                        if($remotefiles[$entry][2]=='directory')
                                            {
                                                $remoteIsDir= true;
                                            }
                                        else 
                                            {
                                                $remoteIsDir= false;
                                            
                                            }
                                                
                                        $remoteIsDir=is_dir($remote.'/'.$entry);

					if(!$remoteIsDir){
						$this->totalSize+=$remoteFileSize;
						$this->totalFiles++;
					}

					if(!empty($file)&&($file['modify']+43200)>=filemtime($remote.'/'.$entry)&&$file['size']==$remoteFileSize&&
					!$remoteIsDir){
						//do nothing, this is sync. copy
					}else{

						if(in_array($entry,$this->exclude_list)){
							continue;
						}

						if($remoteIsDir){
							//recurse to sync. directory
							if(empty($file)){
								//if file with the same name as directory it'll fail
								//$conId=$this->conIds[$this->getIdleStreamIndex()];
                                                                if (!mkdir($local.'/'.$entry, 0777, true)) {
                                                                    die('Failed to create folders...');
                                                                }
								//@ftp_mkdir($conId,$remote.'/'.$entry);

								chmod($local.'/'.$entry, fileperms ($remote.'/'.$entry ) & 0777 );
							}

							$this->syncLocalDir($remote.'/'.$entry,$local.'/'.$entry,false);
						}else{
							//if file existent remove it
							if(!empty($file)){
								delete($local.'/'.$entry);
							}

							//sync. file
							$this->DownloadFile($remote.'/'.$entry,$local.'/'.$entry);

							$this->transferredSize+=$remoteFileSize;
							$this->transferredFiles++;

						}
					}
					$this->continueDownload();//to make a progress in download queue
				}
			}
			//closedir($handle);

			if($this->verbose){
				echo $local. ' : sync'."\r\n";
				flush();
			}
		//}
	}
        
        //My Function To get local file information same as ftp_raw_list()
        //Author Shamim Ahmed Chowdhury
        
   function local_rawlist($file){     
        
        $perms = fileperms($file);

if (($perms & 0xC000) == 0xC000) {
    // Socket
    $info = 's';
} elseif (($perms & 0xA000) == 0xA000) {
    // Symbolic Link
    $info = 'l';
} elseif (($perms & 0x8000) == 0x8000) {
    // Regular
    $info = '-';
} elseif (($perms & 0x6000) == 0x6000) {
    // Block special
    $info = 'b';
} elseif (($perms & 0x4000) == 0x4000) {
    // Directory
    $info = 'd';
} elseif (($perms & 0x2000) == 0x2000) {
    // Character special
    $info = 'c';
} elseif (($perms & 0x1000) == 0x1000) {
    // FIFO pipe
    $info = 'p';
} else {
    // Unknown
    $info = 'u';
}

// Owner
$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x' ) :
            (($perms & 0x0800) ? 'S' : '-'));

// Group
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x' ) :
            (($perms & 0x0400) ? 'S' : '-'));

// World
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x' ) :
            (($perms & 0x0200) ? 'T' : '-'));

echo $info;
return  $info;      
        
$lfileowner = posix_getpwuid(fileowner($file))  ; 
$lfilegroup = posix_getgrgid(filegroup($file));
$lfilesize = filesize($file);
}       
        
        
        
        
        
}
?>