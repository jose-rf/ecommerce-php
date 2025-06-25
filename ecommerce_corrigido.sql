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
('Notebook X1000', 'Notebook com processador Intel i5, 8GB RAM e SSD 256GB', 3899.00, 'https://cdn.pixabay.com/photo/2016/11/29/05/08/laptop-1869307_1280.jpg', 1),
('Notebook Gamer GX15', 'Notebook gamer com RTX 3060, 16GB RAM, 1TB SSD', 7599.90, 'https://cdn.pixabay.com/photo/2015/01/21/14/14/apple-606761_1280.jpg', 1),
('Notebook UltraSlim', 'Ultrabook leve com tela Full HD de 14” e 512GB SSD', 4999.00, 'https://cdn.pixabay.com/photo/2014/05/02/21/50/home-office-336377_1280.jpg', 1),

('Monitor LG 24"', 'Monitor LED LG 24 polegadas Full HD, HDMI e VGA', 899.90, 'https://cdn.pixabay.com/photo/2015/01/08/18/25/office-593310_1280.jpg', 3),
('Monitor Samsung 27"', 'Monitor curvo 27” com 144Hz e FreeSync', 1399.00, 'https://cdn.pixabay.com/photo/2015/01/21/14/14/apple-606761_1280.jpg', 3),
('Monitor Acer Nitro', 'Monitor gamer 23,8” com 165Hz e IPS', 1249.00, 'https://cdn.pixabay.com/photo/2016/11/29/03/53/computer-1869236_1280.jpg', 3),

('Mouse Sem Fio', 'Mouse ergonômico com conexão USB wireless', 79.90, 'https://cdn.pixabay.com/photo/2014/04/05/11/39/mouse-316446_1280.jpg', 2),
('Mouse Gamer RGB', 'Mouse com 7200 DPI e iluminação personalizável', 129.90, 'https://cdn.pixabay.com/photo/2016/11/29/09/32/mouse-1869561_1280.jpg', 2),
('Teclado Mecânico', 'Teclado mecânico com iluminação RGB', 299.00, 'https://cdn.pixabay.com/photo/2016/11/29/03/53/keyboard-1869235_1280.jpg', 2),
('Teclado Wireless', 'Teclado slim sem fio com conexão Bluetooth', 189.00, 'https://cdn.pixabay.com/photo/2016/11/29/03/53/keyboard-1869234_1280.jpg', 2),
('Headset Gamer', 'Headset com som surround 7.1 e microfone', 249.99, 'https://cdn.pixabay.com/photo/2021/01/14/17/55/headphones-5916717_1280.jpg', 2),
('Headset Wireless Pro', 'Headset sem fio com cancelamento ativo de ruído', 449.00, 'https://cdn.pixabay.com/photo/2021/01/14/17/55/headphones-5916718_1280.jpg', 2),
('Webcam Full HD', 'Webcam 1080p com microfone embutido', 199.90, 'https://cdn.pixabay.com/photo/2016/11/29/03/53/webcam-1869233_1280.jpg', 2),

('Hub USB-C 5 em 1', 'Expansor com HDMI, USB 3.0 e leitor de cartão', 149.00, 'https://cdn.pixabay.com/photo/2020/04/02/17/03/usb-4994385_1280.jpg', 4),
('Suporte para Notebook', 'Suporte ajustável com resfriamento', 89.90, 'https://cdn.pixabay.com/photo/2020/05/01/06/45/laptop-5116482_1280.jpg', 4),
('Base Refrigerada RGB', 'Base com ventiladores e LED para notebook gamer', 179.00, 'https://cdn.pixabay.com/photo/2020/05/01/06/45/laptop-5116483_1280.jpg', 4),
('Case SSD M.2', 'Gabinete USB 3.1 para SSD NVMe', 79.00, 'https://cdn.pixabay.com/photo/2020/04/02/17/03/usb-4994386_1280.jpg', 4),
('Cabo HDMI 2.1', 'Cabo com suporte a 8K e 120Hz', 59.90, 'https://cdn.pixabay.com/photo/2016/11/29/03/53/hdmi-1869232_1280.jpg', 4),
('Adaptador USB Wi-Fi', 'Mini adaptador Wi-Fi 5GHz USB', 89.00, 'https://cdn.pixabay.com/photo/2020/04/02/17/03/usb-4994387_1280.jpg', 4),
('Camiseta Tech', 'Camiseta de algodão com estampa moderna', 59.90, 'https://cdn.pixabay.com/photo/2016/03/27/22/16/t-shirt-1280976_1280.jpg', 4);

