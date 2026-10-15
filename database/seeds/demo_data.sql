USE recycle_here;

SET NAMES utf8mb4;

-- =========================================================
-- USUÁRIO DE DEMONSTRAÇÃO
-- =========================================================

INSERT INTO users (
    name,
    email,
    password_hash,
    role
)
VALUES (
    'Cooperativa Recycle Here',
    'empresa@recyclehere.local',
    '$2y$10$1R7XKkOP1YqleDmDzyfQ/uS06oyMfluk20aBdouCRodEIFYNoXZK6',
    'company'
);


-- =========================================================
-- EMPRESA DE DEMONSTRAÇÃO
-- =========================================================

INSERT INTO companies (
    user_id,
    name,
    cnpj,
    phone
)
VALUES (
    LAST_INSERT_ID(),
    'Cooperativa Recycle Here',
    '12345678000190',
    '15999999999'
);


SET @company_id = LAST_INSERT_ID();


-- =========================================================
-- PONTOS DE COLETA
-- =========================================================

INSERT INTO collection_points (
    company_id,
    name,
    street,
    number,
    neighborhood,
    city,
    state,
    phone,
    opening_hours
)
VALUES
(
    @company_id,
    'Cooperativa Recicla Sorocaba',
    'Rua Exemplo',
    '150',
    'Centro',
    'Sorocaba',
    'SP',
    '1500000000',
    'Segunda a sexta-feira, das 8h às 17h.'
),
(
    @company_id,
    'Ecoponto Campolim',
    'Avenida Exemplo',
    '250',
    'Campolim',
    'Sorocaba',
    'SP',
    '1500000001',
    'Segunda a sábado, das 8h às 18h.'
),
(
    @company_id,
    'Cooperativa Zona Norte',
    'Rua Exemplo Norte',
    '300',
    'Zona Norte',
    'Sorocaba',
    'SP',
    '1500000002',
    'Segunda a sexta-feira, das 9h às 17h.'
);


-- =========================================================
-- RELAÇÃO ENTRE PONTOS E MATERIAIS
-- =========================================================

SET @point1 = (
    SELECT id
    FROM collection_points
    WHERE name = 'Cooperativa Recicla Sorocaba'
    LIMIT 1
);

SET @point2 = (
    SELECT id
    FROM collection_points
    WHERE name = 'Ecoponto Campolim'
    LIMIT 1
);

SET @point3 = (
    SELECT id
    FROM collection_points
    WHERE name = 'Cooperativa Zona Norte'
    LIMIT 1
);


INSERT INTO collection_point_material (
    collection_point_id,
    material_id
)
SELECT @point1, id
FROM materials
WHERE slug IN ('papel', 'plastico', 'vidro');


INSERT INTO collection_point_material (
    collection_point_id,
    material_id
)
SELECT @point2, id
FROM materials
WHERE slug IN ('eletronicos', 'pilhas-baterias');


INSERT INTO collection_point_material (
    collection_point_id,
    material_id
)
SELECT @point3, id
FROM materials
WHERE slug IN ('vidro', 'metal');