-- Schéma minimal e-commerce (MySQL)
CREATE TABLE IF NOT EXISTS categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image_url VARCHAR(255),
    categorie_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_produit_categorie FOREIGN KEY (categorie_id) REFERENCES categorie(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS panier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_panier_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS panier_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    panier_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL DEFAULT 1,
    CONSTRAINT fk_panier_item_panier FOREIGN KEY (panier_id) REFERENCES panier(id) ON DELETE CASCADE,
    CONSTRAINT fk_panier_item_produit FOREIGN KEY (produit_id) REFERENCES produit(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    statut VARCHAR(50) NOT NULL DEFAULT 'payee',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_commande_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS commande_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_commande_item_commande FOREIGN KEY (commande_id) REFERENCES commande(id) ON DELETE CASCADE,
    CONSTRAINT fk_commande_item_produit FOREIGN KEY (produit_id) REFERENCES produit(id) ON DELETE CASCADE
);

-- Données de démonstration
INSERT INTO categorie (nom) VALUES ('Catégorie A'), ('Catégorie B');

-- Catalogue démo vêtements
INSERT INTO produit (nom, description, prix, stock, image_url, categorie_id) VALUES
('T-shirt coton blanc', 'T-shirt unisexe 100% coton, coupe régulière.', 14.90, 50, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800', 1),
('ao dài, Tenu traditionnel vietnamienne', 'Il s''agit d''une tenue traditionnelle vietnamienne composée d''une tunique ajustée et d''un pantalon, souvent portée lors de cérémonies ou d''événements importants.', 24.90, 20, 'https://images.unsplash.com/photo-1745750003557-b666d0ea0104?q=80&w=668&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 2), 

('Polo Ralph Lauren', 'Polo Ralph Lauren – Classique et Élégance 
 
Couleur : Multiple choix de couleurs classiques (blanc, bleu marine, rouge, etc.) 
 
Logo : Poney Ralph Lauren brodé sur la poitrine 
 
Composition : 100% coton piqué 
 
Coupe : Ajustée, pour un look moderne 
 
Entretien : Lavable en machine, facile à entretenir 
 
Ce polo polyvalent est parfait pour des occasions décontractées, tout en restant chic. Associez-le à un jean ou un chino pour une allure élégante et intemporelle. ', 155.00, 42, ' http://static.galerieslafayette.com/media/733/73390211/G_73390211_233_ZP_1.jpg ',2); 

