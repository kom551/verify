<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-12-7
 * Time: 下午9:30
 */

class index extends Control{

    function index()
    {
        //载入模型
        parent::__construct();
        $this->vcodemodel = $this->Model('vcodemodel');
        $this->archive = $this->Model('archive');
        global $cfg_ml;
        $this->cfg_ml = $cfg_ml;
    }

    function ac_index()
    {
        $this->SetTemplate('index.htm');
        $this->Display();
    }

    function ac_use_vcode()
    {
        $vcode =  request('vcode', '');
        if($vcode)
        {
            $rs = $this->vcodemodel->use_code($vcode,$this->cfg_ml->M_ID,$this->cfg_ml->M_UserName);
            if($rs)
            {
                ShowMsg('序列号使用成功','?ct=index');
                exit();
            }else{
                ShowMsg('序列号使用失败','?ct=index');
                exit();
            }
        }
        else{
            ShowMsg('序列号为空','?ct=index');
        }
    }


} 