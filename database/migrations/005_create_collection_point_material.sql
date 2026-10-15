USE recycle_here;

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS collection_point_material (
    collection_point_id INT UNSIGNED NOT NULL,

    material_id INT UNSIGNED NOT NULL,

    PRIMARY KEY (
        collection_point_id,
        material_id
    ),

    CONSTRAINT fk_point_material_point
        FOREIGN KEY (collection_point_id)
        REFERENCES collection_points(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_point_material_material
        FOREIGN KEY (material_id)
        REFERENCES materials(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);