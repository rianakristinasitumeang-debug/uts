PRAGMA foreign_keys = ON;

CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code TEXT NOT NULL UNIQUE,
    name TEXT NOT NULL,
    category TEXT NOT NULL,
    description TEXT NOT NULL,
    price INTEGER NOT NULL CHECK (price > 0),
    stock INTEGER NOT NULL DEFAULT 0 CHECK (stock >= 0),
    image_url TEXT NOT NULL,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (code, name, category, description, price, stock, image_url) VALUES
('RA-001', 'Lampu Gantung Lembayung', 'Penerangan', 'Kap lampu rotan yang dianyam tangan, memberi bayangan lembut saat senja tiba.', 685000, 8, 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=1000&q=85'),
('RA-002', 'Keranjang Ranting Pagi', 'Penyimpanan', 'Keranjang serbaguna dari serat pandan dengan pegangan kulit nabati.', 328000, 14, 'https://images.unsplash.com/photo-1593085260707-5377ba37f868?auto=format&fit=crop&w=1000&q=85'),
('RA-003', 'Kursi Santai Akar', 'Furnitur', 'Rangka kayu jati bersertifikat dengan dudukan anyaman yang nyaman.', 2450000, 3, 'https://images.unsplash.com/photo-1598300056393-4aac492f4344?auto=format&fit=crop&w=1000&q=85'),
('RA-004', 'Alas Meja Pesisir', 'Tekstil', 'Set dua alas meja katun tenun dengan palet biru laut dan pasir.', 195000, 22, 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1000&q=85'),
('RA-005', 'Vas Tanah Merah', 'Keramik', 'Vas keramik stoneware bertekstur, dibentuk dan dibakar di Bantul.', 410000, 6, 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?auto=format&fit=crop&w=1000&q=85'),
('RA-006', 'Tote Anyam Senja', 'Aksesori', 'Tas harian ringan dari daun lontar, lapis dalam kain tenun lokal.', 275000, 11, 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=1000&q=85'),
('RA-007', 'Cermin Bingkai Padi', 'Dekorasi', 'Cermin bundar dengan bingkai serat alam, dianyam dalam jumlah terbatas.', 795000, 4, 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1000&q=85'),
('RA-008', 'Bantal Sulur Hijau', 'Tekstil', 'Sarung bantal katun tenun dengan motif sulur yang dibuat alat tenun bukan mesin.', 355000, 17, 'https://images.unsplash.com/photo-1584100936595-c0654b55a2e2?auto=format&fit=crop&w=1000&q=85');
