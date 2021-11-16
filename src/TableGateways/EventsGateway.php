<?php
namespace Src\TableGateways;

class EventsGateway {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT 
                id, name, description, category, start_date,sponsors,maxAttendees
            FROM
                events;
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
                id, name, description, category, start_date,sponsors,maxAttendees
            FROM
                events
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
            INSERT INTO events 
                (name, description, category, start_date, sponsors, maxAttendees)
            VALUES
                (:name, :description, :category, :start_date, :sponsors, :maxAttendees);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'name' => $input['name'],
                'description'  => $input['description'],
                'category' => $input['category'] ?? null,
                'start_date' => $input['start_date'] ?? null,
                'sponsors' => $input['sponsors'] ?? null,
                'maxAttendees' => $input['maxAttendees'],
                
                
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function update($id, Array $input)
    {
        $statement = "
            UPDATE events
            SET 
                name = :name,
                description  = :description,
                category = :category,
                start_date = :start_date,
                sponsors = :sponsors,
                maxAttendees = :maxAttendees
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'name' => $input['name'],
                'description'  => $input['description'],
                'category' => $input['category'] ?? null,
                'start_date' => $input['start_date'] ?? null,
                'sponsors' => $input['sponsors'] ?? null,
                'maxAttendees' => $input['maxAttendees'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM events
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
