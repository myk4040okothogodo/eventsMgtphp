<?php
namespace Src\TableGateways;

class ReservationsGateway {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT 
                ticket_id, user_id, event_id, Vip, Regular
            FROM
                reservations;
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
                ticket_id, user_id, event_id, Vip, Regular
            FROM
                reservations
            WHERE ticket_id = ?;
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
            INSERT INTO reservations
                (user_id,event_id, Vip, Regular)
            VALUES
                (:user_id, :event_id, :Vip, :Regular);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'user_id' => $input['user_id'],
                'event_id'  => $input['event_id'],
                'Vip' => $input['Vip'] ?? null,
                'Regular' => $input['Regular'] ?? null,

                
                
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function update($id, Array $input)
    {
        $statement = "
            UPDATE reservations
            SET 
                Vip= :Vip,
                Regular  = :Regular,
            WHERE ticket_id = :ticket_id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'tikcet_id' => (int) $id,
                'Vip' => $input['Vip'],
                'Regular'  => $input['Regular'],
                
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM reservations
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
