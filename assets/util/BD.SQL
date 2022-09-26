CREATE TABLE "public"."usuario" (
  "id_usuario" SERIAL PRIMARY KEY NOT NULL,
  "nom" varchar COLLATE "pg_catalog"."default" NOT NULL,
  "ap" varchar COLLATE "pg_catalog"."default" NOT NULL,
  "am" varchar COLLATE "pg_catalog"."default" NOT NULL,
  "correo" varchar COLLATE "pg_catalog"."default" NOT NULL,
  "fecha_nac" date NOT NULL,
  "fk_id_cat_tipo_usuario" int4 NOT NULL,
  "pass" text COLLATE "pg_catalog"."default" NOT NULL,
  "fecha_reg" timestamp(6) NOT NULL DEFAULT now(),
  "activo" bool DEFAULT true
)
;


CREATE TABLE "public"."cat_tipo_usuario" (
  "id_cat_tipo_usuario" SERIAL PRIMARY KEY NOT NULL,
  "tipo_usuario" varchar COLLATE "pg_catalog"."default" NOT NULL

)
;

CREATE TABLE img_system (
  "id_img_system" SERIAL PRIMARY KEY NOT NULL,
  "archivo_nombre" varchar COLLATE "pg_catalog"."default" NOT NULL,
  "archivo_tipo" varchar COLLATE "pg_catalog"."default" NOT NULL,
  "archivo_peso" int4 NOT NULL,
  "archivo_ruta" varchar COLLATE "pg_catalog"."default" NOT NULL,
  "archivo_fecha" timestamp(6) NOT NULL DEFAULT now()
);