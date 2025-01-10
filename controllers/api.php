<?php
require '../nebus_project/config/db.php';

$endpoint = strtolower($_GET['endpoint'] ?? ''); // Приводим к нижнему регистру для большей надежности
$query = mb_strtolower($_GET['query'] ?? ''); // Приводим поисковый запрос к нижнему регистру

switch ($endpoint) {
    case 'phones':
        handlePhonesRequest($query);
        break;

    case 'organizations':
        handleOrganizationsRequest($query);
        break;

    case 'activities':
        handleActivitiesRequest($query);
        break;

    case 'buildings':
        handleBuildingsRequest($query);
        break;

    case 'organization_activities':
        handleOrganizationActivitiesRequest($query);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Метод или ресурс не найден'], JSON_UNESCAPED_UNICODE);
        break;
}


// Телефоны
function handlePhonesRequest($query) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            phones.id, 
            organizations.name AS organization_name, 
            phones.phone_number 
        FROM phones 
        JOIN organizations ON phones.organization_id = organizations.id
        WHERE LOWER(organizations.name) LIKE :query OR LOWER(phones.phone_number) LIKE :query
    ");
    $stmt->execute(['query' => '%' . $query . '%']);
    outputResult($stmt, "Телефоны");
}

// Организации
function handleOrganizationsRequest($query) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            organizations.id, 
            organizations.name, 
            buildings.address AS building_address 
        FROM organizations 
        JOIN buildings ON organizations.building_id = buildings.id
        WHERE LOWER(organizations.name) LIKE :query OR LOWER(buildings.address) LIKE :query
    ");
    $stmt->execute(['query' => '%' . $query . '%']);
    outputResult($stmt, "Организации");
}

// Виды деятельности
function handleActivitiesRequest($query) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            a1.id, 
            a1.name, 
            a2.name AS parent_name 
        FROM activities a1 
        LEFT JOIN activities a2 ON a1.parent_id = a2.id
        WHERE LOWER(a1.name) LIKE :query OR LOWER(a2.name) LIKE :query
    ");
    $stmt->execute(['query' => '%' . $query . '%']);
    outputResult($stmt, "Виды деятельности");
}

// Здания
function handleBuildingsRequest($query) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            buildings.id, 
            buildings.address, 
            buildings.latitude, 
            buildings.longitude 
        FROM buildings
        WHERE LOWER(buildings.address) LIKE :query
    ");
    $stmt->execute(['query' => '%' . $query . '%']);
    outputResult($stmt, "Здания");
}

// Деятельность организаций
function handleOrganizationActivitiesRequest($query) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT 
            organization_activities.id, 
            organizations.name AS organization_name, 
            activities.name AS activity_name 
        FROM organization_activities 
        JOIN organizations ON organization_activities.organization_id = organizations.id 
        JOIN activities ON organization_activities.activity_id = activities.id
        WHERE LOWER(organizations.name) LIKE :query OR LOWER(activities.name) LIKE :query
    ");
    $stmt->execute(['query' => '%' . $query . '%']);
    outputResult($stmt, "Деятельность организаций");
}

function api_request($query, $endpoint) {
    global $pdo;

    $sql = '';
    switch ($endpoint) {
        case 'buildings':
            $sql = "
                SELECT 
                    id, 
                    address, 
                    latitude, 
                    longitude 
                FROM buildings 
                WHERE LOWER(address) LIKE :query
            ";
            break;

        case 'activities':
            $sql = "
                SELECT 
                    a1.id, 
                    a1.name AS activity_name, 
                    a2.name AS parent_activity_name 
                FROM activities a1 
                LEFT JOIN activities a2 ON a1.parent_id = a2.id
                WHERE LOWER(a1.name) LIKE :query OR LOWER(a2.name) LIKE :query
            ";
            break;

        case 'organizations':
            $sql = "
                SELECT 
                    organizations.id, 
                    organizations.name, 
                    buildings.address AS building_address 
                FROM organizations 
                JOIN buildings ON organizations.building_id = buildings.id
                WHERE LOWER(organizations.name) LIKE :query OR LOWER(buildings.address) LIKE :query
            ";
            break;

        case 'phones':
            $sql = "
                SELECT 
                    phones.id, 
                    phones.phone_number, 
                    organizations.name AS organization_name 
                FROM phones 
                JOIN organizations ON phones.organization_id = organizations.id
                WHERE LOWER(phones.phone_number) LIKE :query OR LOWER(organizations.name) LIKE :query
            ";
            break;

        case 'organization_activities':
            $sql = "
                SELECT 
                    organization_activities.id, 
                    organizations.name AS organization_name, 
                    activities.name AS activity_name 
                FROM organization_activities 
                JOIN organizations ON organization_activities.organization_id = organizations.id 
                JOIN activities ON organization_activities.activity_id = activities.id
                WHERE LOWER(organizations.name) LIKE :query OR LOWER(activities.name) LIKE :query
            ";
            break;

        default:
            return null;
    }

    // Выполняем запрос
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['query' => '%' . mb_strtolower($query) . '%']);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Универсальная функция для вывода результатов
function outputResult($stmt, $title) {
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>$title:</h3>";
    if ($data) {
        foreach ($data as $item) {
            echo '<div class="data-item">';
            foreach ($item as $key => $value) {
                echo "<p><strong>$key:</strong> $value</p>";
            }
            echo '</div>';
        }
    } else {
        echo "<p>Ничего не найдено.</p>";
    }
}
?>