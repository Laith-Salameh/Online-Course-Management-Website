<?php

class BaseModel
{
	protected $table;
    function __construct($db,$table) {
        try {
            $this->db = $db;
			$this->table = $table;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function getAll()
    {
        $sql = "SELECT * FROM ".$this->table;
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    
    public function deleteById($id)
    {
        $sql = "DELETE FROM ".$this->table." WHERE id = :table_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':table_id' => $id));
    }
}
