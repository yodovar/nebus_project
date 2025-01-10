
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nebus</title>
    <link rel="stylesheet" href="/nebus_project/views/css/products.css">
</head>
<body>
   

    <div class="menu">
        <a href="?endpoint=phones" class="<?= isset($_GET['endpoint']) && $_GET['endpoint'] === 'phones' ? 'active' : '' ?>">Телефоны</a>
        <a href="?endpoint=organizations" class="<?= isset($_GET['endpoint']) && $_GET['endpoint'] === 'organizations' ? 'active' : '' ?>">Организации</a>
        <a href="?endpoint=activities" class="<?= isset($_GET['endpoint']) && $_GET['endpoint'] === 'activities' ? 'active' : '' ?>">Виды деятельности</a>
        <a href="?endpoint=buildings" class="<?= isset($_GET['endpoint']) && $_GET['endpoint'] === 'buildings' ? 'active' : '' ?>">Здания</a>
        <a href="?endpoint=organization_activities" class="<?= isset($_GET['endpoint']) && $_GET['endpoint'] === 'organization_activities' ? 'active' : '' ?>">Деятельность организаций</a>
    </div>

    <form class="search" method="get">
        <input type="text" name="query" placeholder="Введите ключевое слово для поиска" value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
        <input type="hidden" name="endpoint" value="<?= htmlspecialchars($_GET['endpoint'] ?? '') ?>">
        <button type="submit">Поиск</button>
    </form>

    <div class="content">
        <div class="data-container">
            <?php
            

            
            if (isset($_GET['query']) && isset($_GET['endpoint'])) {
                $query = trim($_GET['query']);
                $endpoint = trim($_GET['endpoint']);

                // Получаем данные через API
                $data = api_request($query, $endpoint);

                if (!empty($data)) {
                    foreach ($data as $item) {
                        echo '<div class="data-item">';
                        foreach ($item as $key => $value) {
                            echo '<p><strong>' . htmlspecialchars($key) . ':</strong> ' . htmlspecialchars($value ?? '') . '</p>';
                        }
                        echo '</div>';
                    }
                } else {
                    echo '<p>Нет данных для отображения по запросу "' . htmlspecialchars($query) . '".</p>';
                }
            } else {
                echo '<p>Выберите категорию и выполните поиск.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>
