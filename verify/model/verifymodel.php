<?php


class verifymodel extends Model
{


    function verifymodel()
    {
        parent::__construct();
        require_once DEDEVCODE.'/data/common.inc.php';
    }

    function get_verifycode($wheresql="",$orderby="ASC")
    {
        if($wheresql)
        {
            $query = "#";
            $this->dsql->SetQuery($query);
            $this->dsql->Execute();
            $rows = array();
            while($row = $this->dsql->GetArray())
            {
                $rows[] = $row;
            }
            return $rows;
        }else{
            return FALSE;
        }
    }

    function save_add($arc,$codes)
    {
        if($arc['title'])
        {
            $title = $arc['title'];
            $arcid = $arc['id'];
            if(is_array($codes))
            {
                $ctime = date('Y-m-d H:i:s',time());
                foreach($codes as $code)
                {
                    $query = "INSERT INTO `#@__verifycode`(vcode, arcid, title, state)
                      VALUES('{$code}','{$arcid}','{$title}',0);";
                    $this->dsql->ExecuteNoneQuery($query);
                }
                return TRUE;
            }
        }
        return FALSE;
    }

    function create_code($num=0,$arcid='')
    {
        $vcodes = array();
        for($i=0;$i<$num;$i++)
        {
            $hashcode = $arcid.$i.time();
            $crc = abs(crc32($hashcode));
            if( $crc & 0x80000000){
                $crc ^= 0xffffffff;
                $crc += 1;
            }
            $vcodes[] = substr($crc,0,2).$arcid.substr($crc,2,4).date('md',time()).substr($crc,6);
        }
        return $vcodes;
    }

    function del_vcode($ids = "")
    {
        if(is_array($ids))
        {
            foreach($ids as $id)
            {
                $query = "DELETE FROM `#@__verifycode` WHERE id='$id'";
                $this->dsql->ExecuteNoneQuery($query);
            }
            return TRUE;
        }
        elseif($ids){
            $query = "DELETE FROM `#@__verifycode` WHERE id='$ids'";
            if($this->dsql->ExecuteNoneQuery($query))
            {
                return TRUE;
            }else{
                return FALSE;
            }
        }
        else{
            return FALSE;
        }
    }
}
