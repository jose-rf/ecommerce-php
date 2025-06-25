-- Criação do banco
CREATE DATABASE IF NOT EXISTS ecommerce;
USE ecommerce;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  senha VARCHAR(255)
);

-- Tabela de categorias
CREATE TABLE IF NOT EXISTS categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL
);

-- Tabela de produtos
CREATE TABLE IF NOT EXISTS produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100),
  descricao TEXT,
  preco DECIMAL(10,2),
  imagem VARCHAR(255),
  categoria_id INT,
  FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Tabela de pedidos
CREATE TABLE IF NOT EXISTS pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT,
  data DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabela de itens do pedido
CREATE TABLE IF NOT EXISTS itens_pedido (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT,
  produto_id INT,
  quantidade INT,
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
  FOREIGN KEY (produto_id) REFERENCES produtos(id)
);
 INSERT INTO categorias (nome) VALUES
('Notebooks'),
('Periféricos'),
('Monitores'),
('Acessórios');

INSERT INTO produtos (nome, descricao, preco, imagem, categoria_id) VALUES
('Notebook X1000', 'Notebook com processador Intel i5, 8GB RAM e SSD 256GB', 3899.00, 'notebook1.jpg', 1),
('Notebook Gamer GX15', 'Notebook gamer com RTX 3060, 16GB RAM, 1TB SSD', 7599.90, 'notebook2.jpg', 1),
('Notebook UltraSlim', 'Ultrabook leve com tela Full HD de 14” e 512GB SSD', 4999.00, 'notebook3.jpg', 1),

('Monitor LG 24"', 'Monitor LED LG 24 polegadas Full HD, HDMI e VGA', 899.90, 'monitor1.jpg', 3),
('Monitor Samsung 27"', 'Monitor curvo 27” com 144Hz e FreeSync', 1399.00, 'monitor2.jpg', 3),
('Monitor Acer Nitro', 'Monitor gamer 23,8” com 165Hz e IPS', 1249.00, 'monitor3.jpg', 3),

('Mouse Sem Fio', 'Mouse ergonômico com conexão USB wireless', 79.90, 'mouse1.jpg', 2),
('Mouse Gamer RGB', 'Mouse com 7200 DPI e iluminação personalizável', 129.90, 'mouse2.jpg', 2),
('Teclado Mecânico', 'Teclado mecânico com iluminação RGB', 299.00, 'teclado1.jpg', 2),
('Teclado Wireless', 'Teclado slim sem fio com conexão Bluetooth', 189.00, 'teclado2.jpg', 2),
('Headset Gamer', 'Headset com som surround 7.1 e microfone', 249.99, 'headset1.jpg', 2),
('Headset Wireless Pro', 'Headset sem fio com cancelamento ativo de ruído', 449.00, 'headset2.jpg', 2),
('Webcam Full HD', 'Webcam 1080p com microfone embutido', 199.90, 'webcam1.jpg', 2),

('Hub USB-C 5 em 1', 'Expansor com HDMI, USB 3.0 e leitor de cartão', 149.00, 'hub1.jpg', 4),
('Suporte para Notebook', 'Suporte ajustável com resfriamento', 89.90, 'suporte1.jpg', 4),
('Base Refrigerada RGB', 'Base com ventiladores e LED para notebook gamer', 179.00, 'base1.jpg', 4),
('Case SSD M.2', 'Gabinete USB 3.1 para SSD NVMe', 79.00, 'case1.jpg', 4),
('Cabo HDMI 2.1', 'Cabo com suporte a 8K e 120Hz', 59.90, 'hdmi1.jpg', 4),
('Adaptador USB Wi-Fi', 'Mini adaptador Wi-Fi 5GHz USB', 89.00, 'wifi1.jpg', 4),
('Camiseta Tech', 'Camiseta de algodão com estampa moderna', 59.90, 'camiseta1.jpg', 4);
