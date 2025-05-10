-- rootユーザーの認証方式を変更（既に存在するのでALTER）
ALTER USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY 'mysql';

-- userユーザーの認証方式を変更
ALTER USER 'user'@'%' IDENTIFIED WITH mysql_native_password BY 'password';

-- 念のため権限も付け直し
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON *.* TO 'user'@'%' WITH GRANT OPTION;

FLUSH PRIVILEGES;

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- データベース選択
USE db;

-- ユーザーテーブル
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 商品テーブル
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- カートテーブル
CREATE TABLE IF NOT EXISTS carts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- セッションテーブル
CREATE TABLE IF NOT EXISTS sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_id VARCHAR(255) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- サンプル商品データ
INSERT INTO products (name, price, description) VALUES 
('名前', 1000, 'サンプル商品の説明です。'),
('教科書A', 2500, '初心者向けPHP入門書'),
('教科書B', 3000, 'データベース設計の基礎'),
('ノートPC', 80000, '学習用ノートパソコン'),
('USBメモリ', 1500, '16GB USBメモリ'),
('プログラミング演習キット', 5000, 'PHP+MySQLの実践的な演習キット');