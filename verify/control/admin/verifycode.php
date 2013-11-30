<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-11-30
 * Time: 下午9:59
 */

class verifycode extends Control
{
    function verifycode()
    {
        parent::__construct();
        $this->temp = DEDEAPPTPL.'/admin';
        $this->lurd = new Lurd('#@__verifycode', $this->temp, $this->temp.'/lurd');
        $this->lurd->appName = "验证码管理";
        $this->lurd->isDebug = FALSE;  //开启调试模式后每次都会生成模板
        $this->lurd->stringSafe = 2;  //默认1(只限制不安全的HTML[script、frame等]，0--为不限，2--为不支持HTML
        //获取url
        $this->currurl = GetCurUrl();
        //载入模型
        $this->answer = $this->Model('verifycode');
    }

    function ac_index()
    {
        //指定某字段为强制定义的类型
        $this->ac_list();
    }

    //列出验证码
    function ac_list()
    {
        $ifcheck = request('ifcheck', '2');
        $askid = request('askid', '');
        if($ifcheck == 0)
        {
            $wherequery = "WHERE ifcheck = 0";
            $this->lurd->SetParameter('ifcheck',0);
        }else if($ifcheck == 1){
            $wherequery = "WHERE ifcheck = 1";
            $this->lurd->SetParameter('ifcheck',1);
        }else{
            $wherequery = "";
        }
        if($askid)
        {
            $wherequery .= "WHERE askid =".$askid;
            $this->lurd->SetParameter('askid',$askid);
        }
        $orderquery = "ORDER BY id DESC ";
        //指定每页显示数
        $this->lurd->pageSize = 20;
        //指定某字段为强制定义的类型
        $this->lurd->BindType('dateline', 'TIMESTAMP', 'Y-m-d H:i');
        //获取数据
        $this->lurd->ListData('id,askid,uid,username,dateline,content,ifcheck', $wherequery, $orderquery);
        exit();
    }
}