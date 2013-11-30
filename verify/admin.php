<?php
/**
 * 
 * @version        2011/2/11  沙羡 $
 * @package        DedeCMS.Libraries
 * @copyright      Copyright (c) 2007 - 2011, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 *
 **/
$page_start_time = microtime(TRUE);
require_once(dirname(__file__).'/../include/common.inc.php');
require_once(DEDEINC.'/userlogin.class.php');
require_once(DEDEINC.'/request.class.php');

$dsql->safeCheck = false;
$dsql->SetLongLink();
//检验用户登录状态
$cuserLogin = new userLogin();
if($cuserLogin->getUserID()==-1)
{
	ShowMsg("需要是管理员登陆才能够访问",'index.php');
	exit();
}
define('DEDEASK',dirname(__FILE__));
if($cfg_dede_log=='Y')
{
	$s_nologfile = '_main|_list';
	$s_needlogfile = 'sys_|file_';
	$s_method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
	$s_query = isset($dedeNowurls[1]) ? $dedeNowurls[1] : '';
	$s_scriptNames = explode('/',$s_scriptName);
	$s_scriptNames = $s_scriptNames[count($s_scriptNames)-1];
	$s_userip = GetIP();
	if( $s_method=='POST' || (!preg_match($s_nologfile,$s_scriptNames) && $s_query!='') || preg_match($s_needlogfile,$s_scriptNames) )
	{
		$inquery = "INSERT INTO `#@__log`(adminid,filename,method,query,cip,dtime)
             VALUES ('".$cuserLogin->getUserID()."','{$s_scriptNames}','{$s_method}','".addslashes($s_query)."','{$s_userip}','".time()."');";
		$dsql->ExecuteNoneQuery($inquery);
	}
}

$ct = Request('ct', 'index');
$ac = Request('ac', 'index');

// 统一应用程序入口
RunApp($ct, $ac , 'admin');