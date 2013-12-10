<?php  if(!defined('DEDEINC')) exit("Request Error!");
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-12-7
 * Time: 下午9:13
 */

require_once DEDEINC.'/memberlogin.class.php';

$arctype = 1;

$cfg_ml = new MemberLogin();

$cfg_ask_member = $cfg_basehost.'/member/login.php?gourl='.$callurl;