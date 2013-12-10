<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-12-7
 * Time: 下午11:53
 */


class archive extends Model{

    function get_archiveByid($arcid)
    {
        $query = "SELECT title FROM `#@__archives` WHERE id=".$arcid;
        return $this->dsql->GetOne($query);
    }

    function get_archives()
    {
        $query = "SELECT id,title FROM `#@__archives` ";

        if($this->typeid)
        {
            $query .= "WHERE typeid=".$typeid;
        }
        $this->dsql->SetQuery($query);
        $this->dsql->Execute();
        $rows = array();
        while($row = $this->dsql->GetArray())
        {
            $rows[] = $row;
        }
        return $rows;
    }
}
