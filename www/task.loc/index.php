<?php

use Task\Api\Api;

require 'vendor/autoload.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

$uriSegments = explode('/', trim($requestUri, '/'));

if ($uriSegments[0] === 'products') {
    switch ($requestMethod) {
        case 'GET':
            if (isset($uriSegments[1])) {
                switch ($uriSegments[1]) {
                    case 'getAll':
                        echo json_encode(Api::getAll());
                        break;
                    case 'get':
                        if (isset($_GET['id'])) {
                            echo json_encode(Api::get($_GET['id']));
                        } else {
                            http_response_code(400);
                            echo json_encode(['error' => 'Product ID is required.']);
                        }
                        break;
                    default:
                        http_response_code(404);
                        echo json_encode(['error' => 'API method not found.']);
                        break;
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'API method is required.']);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            if ($uriSegments[1] === 'add' && !empty($data)) {
                echo json_encode(['id' => Api::add($data['name'], $data['supplierEmail'], $data['count'], $data['price'])]);
            } elseif ($uriSegments[1] === 'edit' && !empty($data)) {
                if (isset($data['id'])) {
                    $result = Api::edit($data['id'], $data['name'], $data['supplierEmail'], $data['count'], $data['price']);
                    echo json_encode(['success' => $result]);
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Product ID is required for edit.']);
                }
            } elseif ($uriSegments[1] === 'delete' && !empty($data)) {
                if (isset($data['id'])) {
                    $result = Api::delete($data['id']);
                    echo json_encode(['success' => $result]);
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Product ID is required for delete.']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid request data.']);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'HTTP method not supported.']);
            break;
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'API endpoint not found.']);
}
