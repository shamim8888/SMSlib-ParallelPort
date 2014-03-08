<?php
/*
	File : FTP_SYNC_EXAMPLE.PHP
	Ver. : 1.0.0
	Desc.: The class is made to work as an alternative to rsync when FTP is only available.
		The class use FTP to do synchronization to the target FTP host.
		It copies only the new and modified files after last run of the script.
		You can specify exclude list to the class and any directories or files in this list will be ignored from synchronization.

	Developed By John Saman	(jsaman.59@gmail.com)
	Used and owned by www.ephotobay.com
	Licensed Under Non-Profit Open Software License 3.0 (Non-Profit OSL 3.0)
*/

include_once 'ftp_sync.php';

$RemoteftpServer='ns1';
$RemoteftpUsername='admin';
$RemoteftpPassword='Shamim1008@1969';
$LocalftpServer='ns1';
$LocalftpUsername='admin';
$LocalftpPassword='Shamim1008@1969';
//max simulatnous connections. the more of this number the faster synchronization will be but if set to high number it'll be aborted by FTP server probably so try to keep it in between.
//Note: if it's getting connection refused error try to set this number to low number usually 5 should be fine. 
$maxConnections=5;

//a comma separated list of folder names or file names - full name is required
$exclude_list='cache,template_c,$Recycle.Bin';

$sync=new FTPSync($RemoteftpServer,$RemoteftpUsername,$RemoteftpPassword,$LocalftpServer,$LocalftpUsername,$LocalftpPassword,$maxConnections,$exclude_list);

//This to display detailed information about the directories and files being uploaded - use for testing
$sync->verbose=true;

//start synchronization process
$sync->syncRemoteDir('d:\localdir','.');
$sync->syncLocalDir('remotedir','localdir');

?>