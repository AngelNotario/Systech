-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS systech;
USE systech;

-- Tabla Roles
CREATE TABLE IF NOT EXISTS Roles (
    rol_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    rol_id INT NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    FOREIGN KEY (rol_id) REFERENCES Roles(rol_id)
);

-- Tabla Sucursal
CREATE TABLE IF NOT EXISTS Sucursal (
    sucursal_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    telefono VARCHAR(15),
    email VARCHAR(100)
);

-- Tabla Almacén
CREATE TABLE IF NOT EXISTS Almacen (
    almacen_id INT AUTO_INCREMENT PRIMARY KEY,
    sucursal_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    FOREIGN KEY (sucursal_id) REFERENCES Sucursal(sucursal_id)
);

-- Tabla Categorías para Productos
CREATE TABLE IF NOT EXISTS Categorias (
    categoria_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT
);

-- Tabla Productos
CREATE TABLE IF NOT EXISTS Productos (
    producto_id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    almacen_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES Categorias(categoria_id),
    FOREIGN KEY (almacen_id) REFERENCES Almacen(almacen_id)
);

-- Tabla Clientes
CREATE TABLE IF NOT EXISTS Clientes (
    cliente_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    telefono VARCHAR(15),
    email VARCHAR(100) UNIQUE,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo'
);

-- Tabla Membresías
CREATE TABLE IF NOT EXISTS Membresias (
    membresia_id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    tipo_membresia ENUM('Mensual', 'Trimestral', 'Anual') NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    estado ENUM('Activa', 'Inactiva') DEFAULT 'Activa',
    costo DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES Clientes(cliente_id)
);

-- Tabla Pagos
CREATE TABLE IF NOT EXISTS Pagos (
    pago_id INT AUTO_INCREMENT PRIMARY KEY,
    membresia_id INT NOT NULL,
    fecha_pago DATETIME DEFAULT CURRENT_TIMESTAMP,
    monto DECIMAL(10, 2) NOT NULL,
    metodo_pago ENUM('Efectivo', 'Tarjeta', 'Transferencia') NOT NULL,
    estado ENUM('Completado', 'Pendiente') DEFAULT 'Completado',
    FOREIGN KEY (membresia_id) REFERENCES Membresias(membresia_id)
);

-- Tabla Ventas
CREATE TABLE IF NOT EXISTS Ventas (
    venta_id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    usuario_id INT NOT NULL, -- Llave foránea de Usuario
    fecha_venta DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES Clientes(cliente_id),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(usuario_id)
);

-- Tabla Detalle_Ventas
CREATE TABLE IF NOT EXISTS Detalle_Ventas (
    detalle_venta_id INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (venta_id) REFERENCES Ventas(venta_id),
    FOREIGN KEY (producto_id) REFERENCES Productos(producto_id)
);

-- Tabla Mobiliario
CREATE TABLE IF NOT EXISTS Mobiliario (
    mobiliario_id INT AUTO_INCREMENT PRIMARY KEY,
    sucursal_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    cantidad INT NOT NULL,
    estado ENUM('Disponible', 'En Uso', 'Mantenimiento', 'Dañado') DEFAULT 'Disponible',
    FOREIGN KEY (sucursal_id) REFERENCES Sucursal(sucursal_id)
);

-- Insertar roles iniciales
INSERT INTO Roles (nombre_rol) VALUES ('Administrador'), ('Recepcionista'), ('Entrenador');

-- Insertar un usuario administrador inicial (password: admin123)
INSERT INTO Usuarios (rol_id, username, password, email)
VALUES (1, 'admin', SHA2('admin123', 256), 'admin@gym.com');

-- Insertar una sucursal inicial
INSERT INTO Sucursal (nombre, direccion, telefono, email)
VALUES ('Sucursal Central', 'Calle Principal 123', '123456789', 'central@gym.com');

-- Insertar un almacén inicial
INSERT INTO Almacen (sucursal_id, nombre, descripcion)
VALUES (1, 'Almacén Principal', 'Almacén de la sucursal central');

-- Insertar una categoría inicial
INSERT INTO Categorias (nombre, descripcion)
VALUES ('Suplementos', 'Productos nutricionales y suplementos deportivos');

-- Insertar un producto inicial
INSERT INTO Productos (categoria_id, almacen_id, nombre, descripcion, precio, stock)
VALUES (1, 1, 'Proteína en Polvo', 'Proteína de suero de leche', 25.99, 100);

-- Insertar un cliente inicial
INSERT INTO Clientes (nombre, apellido, telefono, email)
VALUES ('Juan', 'Perez', '987654321', 'juan@example.com');

-- Insertar una membresía inicial
INSERT INTO Membresias (cliente_id, tipo_membresia, fecha_inicio, fecha_fin, costo)
VALUES (1, 'Mensual', '2023-10-01', '2023-11-01', 50.00);

-- Insertar un pago inicial
INSERT INTO Pagos (membresia_id, monto, metodo_pago)
VALUES (1, 50.00, 'Efectivo');

-- Insertar un mobiliario inicial
INSERT INTO Mobiliario (sucursal_id, nombre, descripcion, cantidad)
VALUES (1, 'Máquina de Pesas', 'Máquina para ejercicios de fuerza', 10);