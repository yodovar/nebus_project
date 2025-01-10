CREATE TABLE buildings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(255) NOT NULL,
    latitude DOUBLE NOT NULL,
    longitude DOUBLE NOT NULL
);

CREATE TABLE activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    parent_id INT NULL,
    FOREIGN KEY (parent_id) REFERENCES activities(id)
);

CREATE TABLE organizations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    building_id INT NOT NULL,
    FOREIGN KEY (building_id) REFERENCES buildings(id)
);

CREATE TABLE phones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    organization_id INT NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    FOREIGN KEY (organization_id) REFERENCES organizations(id)
);

CREATE TABLE organization_activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    organization_id INT NOT NULL,
    activity_id INT NOT NULL,
    FOREIGN KEY (organization_id) REFERENCES organizations(id),
    FOREIGN KEY (activity_id) REFERENCES activities(id)
);


INSERT INTO buildings (address, latitude, longitude) VALUES
('г. Москва, ул Ленина 1, офис 3', 55.7558, 37.6833),
('г. Санкт-Петербург, ул. Пушкина 1, офис 5', 59.4793, 30.3351);


INSERT INTO activities (name, parent_id) VALUES
('Еда', NULL),
('Мясная продукция', 1),
('Молочная продукция', 1),
('Автомобили', NULL),
('Грузовые', 4),
('Легковые', 4),
('Запчасти', 6),
('Аксессуары', 6);


INSERT INTO organizations (name, building_id) VALUES
('ООО “Мясо Животных”', 1),
('ООО “Молочная ферма”', 2),
('ООО “Грузовики Р.Ф”', 1);


INSERT INTO phones (organization_id, phone_number) VALUES
(1, '2-222-222'),
(1, '3-333-333'),
(2, '8-925-666'),
(3, '5-555-555');


INSERT INTO organization_activities (organization_id, activity_id) VALUES
(1, 2),  
(1, 3),  
(2, 3),  
(3, 5);  