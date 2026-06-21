INSERT INTO taller_1.migrations (migration,batch) VALUES
	 ('0001_01_01_000000_create_users_table',1),
	 ('0001_01_01_000001_create_cache_table',1),
	 ('0001_01_01_000002_create_jobs_table',1),
	 ('2026_05_13_211528_create_categorias_table',1),
	 ('2026_05_13_211529_create_productos_table',1),
	 ('2026_05_13_211530_create_pedidos_table',1),
	 ('2026_05_13_211531_create_pedido_detalles_table',1),
	 ('2026_05_26_233322_create_carritos_table',1),
	 ('2026_05_27_224941_add_role_to_users_table',2),
	 ('2026_05_28_000000_add_soft_deletes_to_users_and_productos_table',3);
INSERT INTO taller_1.migrations (migration,batch) VALUES
	 ('2026_05_28_000001_add_soft_deletes_to_categorias_table',4),
	 ('2026_05_28_000002_add_soft_deletes_to_carritos_table',5),
	 ('2026_05_28_000003_add_soft_deletes_to_pedidos_table',5),
	 ('2026_05_28_000004_add_soft_deletes_to_pedido_detalles_table',5),
	 ('2026_05_28_000005_create_mensajes_table',6),
	 ('2026_05_28_000006_add_combo_destacado_to_productos_table',6),
	 ('2026_05_28_164820_add_payment_details_to_pedidos_table',7),
	 ('2026_05_28_164846_create_pagina_contenidos_table',8),
	 ('2026_05_28_170537_create_welcome_slides_table',9),
	 ('2026_05_28_010000_normalize_user_roles',10);
INSERT INTO taller_1.migrations (migration,batch) VALUES
	 ('2026_05_29_010000_support_soft_deleted_user_email_reuse',10),
	 ('2026_05_29_020000_create_roles_table_and_link_users',10),
	 ('2026_06_04_140224_create_direccions_table',11),
	 ('2026_06_15_220000_add_telefono_to_users_table',12),
	 ('2026_06_15_221000_backfill_user_telefono_from_direcciones',12);
