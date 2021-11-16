<?php
namespace Src\Controller;

use Src\TableGateways\TicketsGateway;
class TicketsController {
    private $db;
    private $requestMethod;
    private $ticketId;
    private $ticketGateway;
    public function __construct($db, $requestMethod, $ticketId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->ticketId = $ticketId;

        $this->ticketGateway = new TicketsGateway($db);
    }
    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->ticketId) {
                    $response = $this->getTicket($this->ticketId);
                } else {
                    $response = $this->getAllTickets();
                };
                break;
            case 'POST':
                $response = $this->createTicketFromRequest();
                break;
            case 'PUT':
                $response = $this->updateTicketFromRequest($this->ticketId);
                break;
            case 'DELETE':
                $response = $this->deleteTicket($this->ticketId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }
    private function getAllTickets()
    {
        $result = $this->ticketGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
    private function getTicket($id)
    {
        $result = $this->ticketGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
    private function createTicketFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateTicket($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->ticketGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }
    private function updateTicketFromRequest($id)
    {
        $result = $this->ticketGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateTicket($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->ticketGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }
    private function deleteTicket($id)
    {
        $result = $this->ticketGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->ticketGateway->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }
    private function validateTicket($input)
    {
        if (! isset($input['user_id'])) {
            return false;
        }
        if (! isset($input['event_id'])) {
            return false;
        }
        return true;
    }
    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }
    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
?>
