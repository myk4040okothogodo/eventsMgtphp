<?php
namespace Src\Controller;

use Src\TableGateways\CategoriesGateway;

class CategoriesController {

    private $db;
    private $requestMethod;
    private $catId;

    private $categoryGateway;

    public function __construct($db, $requestMethod, $catId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->catId = $catId;

        $this->categoryGateway = new CategoriesGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->catId) {
                    $response = $this->getCategory($this->catId);
                } else {
                    $response = $this->getAllCategories();
                };
                break;
            case 'POST':
                $response = $this->createCategoryFromRequest();
                break;
            case 'PUT':
                $response = $this->updateCategoryFromRequest($this->catId);
                break;
            case 'DELETE':
                $response = $this->deleteCategory($this->catId);
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

    private function getAllCategories()
    {
        $result = $this->categoryGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getCategory($id)
    {
        $result = $this->categoryGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createCategoryFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateCategory($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->categoryGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function updateCategoryFromRequest($id)
    {
        $result = $this->categoryGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateCategory($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->categoryGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function deleteCategory($id)
    {
        $result = $this->categoryGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->categoryGateway->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validateCategory($input)
    {
        if (! isset($input['name'])) {
            return false;
        }
        if (! isset($input['description'])) {
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
