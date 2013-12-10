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
define('APPNAME','vcode');
require_once(dirname(__file__).'/../include/common.inc.php');
require_once(DEDEINC.'/userlogin.class.php');
require_once(DEDEINC.'/request.class.php');

define('DEDEVCODE',dirname(__FILE__));

require_once(DEDEVCODE.'/data/common.inc.php');

global $cfg_ml;
if(!$cfg_ml->M_ID)
{
    ShowMsg('您尚未登录，请先登录','/member/index.php');
    exit;
}



$ct = Request('ct', 'index');
$ac = Request('ac', 'index');

// 统一应用程序入口
RunApp($ct, $ac);
