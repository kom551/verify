<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-11-30
 * Time: 下午9:59
 */

class vcodeadmin extends Control
{
    function vcodeadmin()
    {
        parent::__construct();
        $this->temp = DEDEAPPTPL.'/admin';
        $this->arclurd = new Lurd('#@__archives', $this->temp, $this->temp.'/lurd');
        $this->lurd = new Lurd('#@__verifycode', $this->temp, $this->temp.'/lurd');
        $this->lurd->appName = "验证码管理";
        $this->lurd->isDebug = FALSE;  //开启调试模式后每次都会生成模板
        $this->lurd->stringSafe = 2;  //默认1(只限制不安全的HTML[script、frame等]，0--为不限，2--为不支持HTML
        //$this->lurd->AddLinkTable($this->arclurd,'arcid','id','title');
        require_once DEDEVCODE.'/data/common.inc.php';
        //获取url
        $this->style = 'admin';
        $this->currurl = GetCurUrl();
        //载入模型
        $this->verifymodel = $this->Model('verifymodel');

        $this->archive = $this->Model('archive');
    }

    function ac_index()
    {
        //指定某字段为强制定义的类型
        $this->ac_list();
    }

    //列出验证码
    function ac_list()
    {
        $state = request('state', '2');
        $arcid = request('arcid', '');
        if($state == 0)
        {
            $wherequery = "WHERE state = 0";
            $this->lurd->SetParameter('state',0);
        }else if($state == 1){
            $wherequery = "WHERE state = 1";
            $this->lurd->SetParameter('state',1);
        }else{
            $wherequery = "";
        }
        if($arcid)
        {
            $wherequery .= "WHERE arcid =".$arcid;
            $this->lurd->SetParameter('arcid',$arcid);
        }
        $orderquery = "ORDER BY dede_verifycode.id DESC ";
        //指定每页显示数
        $this->lurd->pageSize = 20;
        //指定某字段为强制定义的类型
        $this->lurd->BindType('gmt_create', 'TIMESTAMP', 'Y-m-d H:i');
        //获取数据
        $this->lurd->ListData('id', $wherequery, $orderquery);
        exit();
    }

    //增加分类
    function ac_add()
    {

        $archives = $this->archive->get_archives();
        $GLOBALS['archives'] = $archives;
        $this->SetTemplate('verifycode_add.htm');
        $this->Display();
    }

//增加分类
    function ac_add_save()
    {
        $num = request('num', '');
        $arcid = request('arcid', '');
        if(!is_numeric($num))
        {
            ShowMsg('数量不正确', '?ct=asktype');
            exit();
        }
        $codes = $this->verifymodel->create_code($num,$arcid);
        $arc = $this->archive->get_archiveByid($arcid);
        $rs = $this->verifymodel->save_add($arc,$codes);
        if($rs)
        {
            ShowMsg('增加分类成功，将返回分类管理页面','?ct=vcodeadmin');
            exit();
        }else{
            ShowMsg('增加分类成功，将返回分类管理页面','?ct=vcodeadmin');
            exit();
        }
    }

    //删除
    function ac_del()
    {
        $id = request('id', '');
        $ids = request('Id','');
        if($id)
        {
            $rs = $this->verifymodel->del_vcode($id);
        }
        if(is_array($ids))
        {
            $rs = $this->verifymodel->del_vcode($ids);
        }
        if($rs)
        {
            ShowMsg('删除分类成功', '?ct=verifycode');
            exit();
        }else{
            ShowMsg('删除分类失败','?ct=verifycode');
            exit();
        }
    }
}