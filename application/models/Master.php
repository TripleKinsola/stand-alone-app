<?php
class Master extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    public function select($where = ""){
        $sql = "SELECT * FROM ".$where;
        $query = $this->db->query($sql, array());
        return $query->result_array();
    }

    public function remove($from = "", $id){
        $sql = "DELETE FROM ".$from." WHERE id = ?";
        $query = $this->db->query($sql, array($id));
    }
    public function visible($from = "", $id, $value = ""){
        $sql = "UPDATE ".$from." SET visible = ? WHERE id = ?";
        $query = $this->db->query($sql, array($value,$id));
    }
}