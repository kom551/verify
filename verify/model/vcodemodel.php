<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-12-7
 * Time: 下午9:30
 */

class vcodemodel extends Model{


    function get_archiveByid($arcid)
    {
        $query = "SELECT title FROM `#@__archives` WHERE id=".$arcid;
        return $this->dsql->GetOne($query);
    }

    function use_code($vcode="",$mid="",$userid="")
    {
        $query = "#";
        $this->dsql->SetQuery($query);
        if($vcode &&  $mid){
            $query = "SELECT * FROM `#@__verifycode` WHERE vcode='".$vcode."' and state=0;";
            $data = $this->dsql->GetOne($query);
            if($data){
                $query = "UPDATE `#@__verifycode` SET state=1, mid='{$mid}', userid='{$userid}' WHERE vcode='{$vcode}';";
                $this->dsql->ExecuteNoneQuery($query);
                $query = "INSERT INTO `#@__member_archives`(mid, arcid,vcode) VALUES('{$mid}','{$data['arcid']}','{$vcode}');";
                $this->dsql->ExecuteNoneQuery($query);
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }

}
} 