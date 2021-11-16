<?php
namespace Src\TableGateways;

class UsersGateway {
    private $db = null;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function findAll()
    {
        $statement = "
            SELECT 
                id, name, email, phone, role
            FROM
                users;
        ";
        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
    public function find($id)
    {
        $statement = "
            SELECT 
                id, name, email, phone, role
            FROM
                users
            WHERE id = ?;
        ";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO users
                (name, email, phone)
            VALUES
                (:name, :email, :phone);
        ";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'name' => $input['name'],
                'email'  => $input['email'],
                'phone' => $input['phone'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
    public function update($id, Array $input)
    {
        $statement = "
            UPDATE users
            SET 
                name = :name,
                email  = :email,
                phone = :phone,
            WHERE id = :id;
        ";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'name' => $input['name'],
                'email'  => $input['email'],
                'phone' => $input['phone'] ?? null,               
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
    public function delete($id)
    {
        $statement = "
            DELETE FROM users
            WHERE id = :id;
        ";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
}
