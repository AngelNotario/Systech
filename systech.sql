-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         9.2.0 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para systech
CREATE DATABASE IF NOT EXISTS `systech` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `systech`;

-- Volcando estructura para tabla systech.almacen
CREATE TABLE IF NOT EXISTS `almacen` (
  `almacen_id` int NOT NULL AUTO_INCREMENT,
  `sucursal_id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`almacen_id`),
  KEY `sucursal_id` (`sucursal_id`),
  CONSTRAINT `almacen_ibfk_1` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursal` (`sucursal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla systech.almacen: ~1 rows (aproximadamente)
INSERT INTO `almacen` (`almacen_id`, `sucursal_id`, `nombre`, `descripcion`) VALUES
	(1, 1, 'Almacén Principal', 'Almacén de la sucursal central');

-- Volcando estructura para tabla systech.cajas
CREATE TABLE IF NOT EXISTS `cajas` (
  `id_caja` int NOT NULL AUTO_INCREMENT,
  `estatus` enum('abierta','cerrada') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hora_apertura` datetime DEFAULT NULL,
  `hora_cierre` datetime DEFAULT NULL,
  `usuario` int NOT NULL,
  `efectivo_inicial` decimal(60,2) NOT NULL,
  `efectivo_final` decimal(60,2) DEFAULT NULL,
  PRIMARY KEY (`id_caja`),
  KEY `FK_caja_usuarios` (`usuario`),
  CONSTRAINT `FK_caja_usuarios` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla systech.cajas: ~1 rows (aproximadamente)
INSERT INTO `cajas` (`id_caja`, `estatus`, `hora_apertura`, `hora_cierre`, `usuario`, `efectivo_inicial`, `efectivo_final`) VALUES
	(2, 'abierta', '2025-04-29 07:47:16', NULL, 1, 100.00, 100.00);

-- Volcando estructura para tabla systech.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `categoria_id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla systech.categorias: ~1 rows (aproximadamente)
INSERT INTO `categorias` (`categoria_id`, `nombre`, `descripcion`) VALUES
	(3, 'Proteinas', 'Suplemento alimenticio con alta concentración de proteína');

-- Volcando estructura para tabla systech.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `cliente_id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  PRIMARY KEY (`cliente_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla systech.clientes: ~2 rows (aproximadamente)
INSERT INTO `clientes` (`cliente_id`, `nombre`, `apellidos`, `telefono`, `email`, `fecha_registro`, `estado`) VALUES
	(1, 'Juan', 'Perez', '987654321', 'juan@example.com', '2025-04-29 07:32:20', 'Activo'),
	(2, 'Angel', 'Notario', '9161297488', 'asd@gmail.com', '2025-04-29 08:16:04', 'Activo');

-- Volcando estructura para tabla systech.membresias
CREATE TABLE IF NOT EXISTS `membresias` (
  `membresia_id` int NOT NULL AUTO_INCREMENT,
  `cliente_id` int NOT NULL,
  `tipo_membresia` enum('Mensual','Trimestral','Anual') NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` enum('Activa','Inactiva') DEFAULT 'Activa',
  `costo` decimal(10,2) NOT NULL,
  PRIMARY KEY (`membresia_id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `membresias_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla systech.membresias: ~2 rows (aproximadamente)
INSERT INTO `membresias` (`membresia_id`, `cliente_id`, `tipo_membresia`, `fecha_inicio`, `fecha_fin`, `estado`, `costo`) VALUES
	(1, 1, 'Mensual', '2023-10-01', '2023-11-01', 'Activa', 350.00),
	(2, 2, 'Anual', '2024-04-29', '2026-04-29', 'Activa', 450.00);

-- Volcando estructura para tabla systech.pagos
CREATE TABLE IF NOT EXISTS `pagos` (
  `pago_id` int NOT NULL AUTO_INCREMENT,
  `membresia_id` int NOT NULL,
  `fecha_pago` datetime DEFAULT CURRENT_TIMESTAMP,
  `monto` decimal(10,2) NOT NULL,
  `metodo_pago` enum('Efectivo','Tarjeta','Transferencia') NOT NULL,
  `estado` enum('Completado','Pendiente') DEFAULT 'Completado',
  PRIMARY KEY (`pago_id`),
  KEY `membresia_id` (`membresia_id`),
  CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`membresia_id`) REFERENCES `membresias` (`membresia_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla systech.pagos: ~1 rows (aproximadamente)
INSERT INTO `pagos` (`pago_id`, `membresia_id`, `fecha_pago`, `monto`, `metodo_pago`, `estado`) VALUES
	(1, 1, '2025-04-29 07:32:20', 50.00, 'Efectivo', 'Completado');

-- Volcando estructura para tabla systech.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `producto_id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `categoria_id` int DEFAULT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `codigo_barras` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_creacion` date NOT NULL,
  `imagen` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`producto_id`),
  UNIQUE KEY `codigo_barras` (`codigo_barras`),
  KEY `idx_productos_categoria` (`categoria_id`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla systech.productos: ~1 rows (aproximadamente)
INSERT INTO `productos` (`producto_id`, `nombre`, `descripcion`, `categoria_id`, `precio_compra`, `precio_venta`, `stock`, `codigo_barras`, `fecha_creacion`, `imagen`) VALUES
	(3, 'Proteina', 'Gold Standard 100% Whey Proteína de suero de leche Optimum Nutrition Chocolate 2 Libras', 3, 800.00, 1200.00, 5, '123456', '2025-04-29', '6810dfee9cbfe-pngwing.com.png'),
	(4, 'Dymatize Elite 100% Whey 5 Lbs Sabor Gourmet Vainilla', 'Elite 100% Whey Proteína de suero de leche Dymatize Vainilla 5 Libras\r\nSuplemento Alimenticio\r\nSabor Vainilla\r\n5 Libras\r\nEste producto no es un medicamento, y es responsabilidad de quien lo recomienda y de quien lo usa.', 3, 800.00, 1500.00, 3, '456123', '2025-04-29', '6810f50e10f01-71--ibg8NjL.__AC_SX300_SY300_QL70_ML2_.jpg');

-- Volcando estructura para tabla systech.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `rol_id` int NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`rol_id`),
  UNIQUE KEY `nombre_rol` (`nombre_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla systech.roles: ~2 rows (aproximadamente)
INSERT INTO `roles` (`rol_id`, `nombre_rol`, `descripcion`) VALUES
	(1, 'Administrador', 'Administrador'),
	(2, 'Vendedor', 'Vendedor');

-- Volcando estructura para tabla systech.rolesusuarios
CREATE TABLE IF NOT EXISTS `rolesusuarios` (
  `usuario_id` int NOT NULL,
  `rol_id` int NOT NULL,
  PRIMARY KEY (`usuario_id`,`rol_id`),
  KEY `rol_id` (`rol_id`),
  CONSTRAINT `rolesusuarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`),
  CONSTRAINT `rolesusuarios_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`rol_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla systech.rolesusuarios: ~2 rows (aproximadamente)
INSERT INTO `rolesusuarios` (`usuario_id`, `rol_id`) VALUES
	(1, 1),
	(2, 2);

-- Volcando estructura para tabla systech.sucursal
CREATE TABLE IF NOT EXISTS `sucursal` (
  `sucursal_id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sucursal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla systech.sucursal: ~1 rows (aproximadamente)
INSERT INTO `sucursal` (`sucursal_id`, `nombre`, `direccion`, `telefono`, `email`) VALUES
	(1, 'Sucursal Central', 'Calle Principal 123', '123456789', 'central@gym.com');

-- Volcando estructura para tabla systech.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario_id` int NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contrasena_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_completo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `estado` enum('activo','inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'activo',
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla systech.usuarios: ~2 rows (aproximadamente)
INSERT INTO `usuarios` (`usuario_id`, `nombre_usuario`, `contrasena_hash`, `correo`, `nombre_completo`, `estado`, `fecha_registro`) VALUES
	(1, 'Admin', '$2y$10$LwLvchksSIotnhRcALXWO.FkgI8C6yhvasbOdG5dJ.rFMBR72Y54q', 'asdas@gmail.com', 'Tenshi Admin', 'activo', '2025-04-07 23:55:19'),
	(2, 'tenshi', '$2y$10$qZ8OHE5NCYpIGNwDY1o6ne6NdWIVq8HIn4pOKwX6Z45yms3P5EQ32', 'angelmini640@gmail.com', 'Angel Notario Posadas', 'activo', '2025-04-26 20:06:32');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
