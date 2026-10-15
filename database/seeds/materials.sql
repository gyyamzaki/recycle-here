USE recycle_here;

SET NAMES utf8mb4;

INSERT INTO materials (
    name,
    slug,
    description
)
VALUES
(
    'Papel',
    'papel',
    'Papelão, folhas, jornais e outros materiais de papel.'
),
(
    'Plástico',
    'plastico',
    'Garrafas PET, embalagens, frascos e outros materiais plásticos.'
),
(
    'Vidro',
    'vidro',
    'Garrafas, potes e outros recipientes de vidro.'
),
(
    'Metal',
    'metal',
    'Latas, peças metálicas e outros materiais metálicos.'
),
(
    'Eletrônicos',
    'eletronicos',
    'Celulares, computadores, cabos e equipamentos eletrônicos.'
),
(
    'Pilhas e baterias',
    'pilhas-baterias',
    'Pilhas domésticas e diferentes tipos de baterias usadas.'
),
(
    'Óleo usado',
    'oleo-usado',
    'Óleo de cozinha usado destinado ao descarte adequado.'
)
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    description = VALUES(description);