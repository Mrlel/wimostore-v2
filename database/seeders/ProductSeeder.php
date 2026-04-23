<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $produits = [
            // Téléphones portables (catégorie_id = 6)
            ['nom' => 'Samsung Galaxy A14', 'categorie_id' => 6, 'prix_achat' => 85000, 'prix_vente' => 100000, 'quantite_stock' => 10],
            ['nom' => 'iPhone 11', 'categorie_id' => 6, 'prix_achat' => 250000, 'prix_vente' => 280000, 'quantite_stock' => 5],
            ['nom' => 'Tecno Spark 10', 'categorie_id' => 6, 'prix_achat' => 90000, 'prix_vente' => 110000, 'quantite_stock' => 8],
            ['nom' => 'Infinix Hot 30', 'categorie_id' => 6, 'prix_achat' => 95000, 'prix_vente' => 115000, 'quantite_stock' => 6],
            ['nom' => 'Itel A60', 'categorie_id' => 6, 'prix_achat' => 60000, 'prix_vente' => 75000, 'quantite_stock' => 12],

            // Accessoires téléphoniques (catégorie_id = 1)
            ['nom' => 'Chargeur Samsung Original', 'categorie_id' => 1, 'prix_achat' => 4000, 'prix_vente' => 6000, 'quantite_stock' => 20],
            ['nom' => 'Écouteurs Bluetooth JBL', 'categorie_id' => 1, 'prix_achat' => 12000, 'prix_vente' => 15000, 'quantite_stock' => 10],
            ['nom' => 'Câble Type-C', 'categorie_id' => 1, 'prix_achat' => 1500, 'prix_vente' => 2500, 'quantite_stock' => 30],
            ['nom' => 'Verre trempé iPhone', 'categorie_id' => 1, 'prix_achat' => 1000, 'prix_vente' => 2000, 'quantite_stock' => 25],
            ['nom' => 'Coque Silicone Universelle', 'categorie_id' => 1, 'prix_achat' => 2000, 'prix_vente' => 4000, 'quantite_stock' => 15],
            ['nom' => 'Batterie PowerBank 10000mAh', 'categorie_id' => 1, 'prix_achat' => 15000, 'prix_vente' => 20000, 'quantite_stock' => 10],
            ['nom' => 'Lampe LED Rechargeable', 'categorie_id' => 1, 'prix_achat' => 7000, 'prix_vente' => 10000, 'quantite_stock' => 8],
            ['nom' => 'Montre connectée T500', 'categorie_id' => 1, 'prix_achat' => 8000, 'prix_vente' => 12000, 'quantite_stock' => 6],
            ['nom' => 'Casque Audio Sony', 'categorie_id' => 1, 'prix_achat' => 18000, 'prix_vente' => 25000, 'quantite_stock' => 4],
            ['nom' => 'Mini Enceinte Bluetooth', 'categorie_id' => 1, 'prix_achat' => 6000, 'prix_vente' => 9000, 'quantite_stock' => 12],

            // Cosmétiques (catégorie_id = 5)
            ['nom' => 'Crème hydratante Nivea', 'categorie_id' => 5, 'prix_achat' => 2500, 'prix_vente' => 4000, 'quantite_stock' => 20],
            ['nom' => 'Lotion éclaircissante Caro White', 'categorie_id' => 5, 'prix_achat' => 3000, 'prix_vente' => 5000, 'quantite_stock' => 15],
            ['nom' => 'Savon Dove', 'categorie_id' => 5, 'prix_achat' => 1000, 'prix_vente' => 2000, 'quantite_stock' => 25],
            ['nom' => 'Huile de coco naturelle', 'categorie_id' => 5, 'prix_achat' => 2500, 'prix_vente' => 4000, 'quantite_stock' => 10],
            ['nom' => 'Shampoing L’Oréal Paris', 'categorie_id' => 5, 'prix_achat' => 3500, 'prix_vente' => 6000, 'quantite_stock' => 12],

            // Parfums (catégorie_id = 7)
            ['nom' => 'Dior Sauvage', 'categorie_id' => 7, 'prix_achat' => 35000, 'prix_vente' => 45000, 'quantite_stock' => 6],
            ['nom' => 'Chanel Coco Mademoiselle', 'categorie_id' => 7, 'prix_achat' => 40000, 'prix_vente' => 50000, 'quantite_stock' => 4],
            ['nom' => 'YSL Black Opium', 'categorie_id' => 7, 'prix_achat' => 38000, 'prix_vente' => 48000, 'quantite_stock' => 5],
            ['nom' => 'Axe Dark Temptation', 'categorie_id' => 7, 'prix_achat' => 6000, 'prix_vente' => 9000, 'quantite_stock' => 10],
            ['nom' => 'Choco Glam (local)', 'categorie_id' => 7, 'prix_achat' => 5000, 'prix_vente' => 8000, 'quantite_stock' => 8],

            // Sacs à main (catégorie_id = 8)
            ['nom' => 'Sac à main cuir femme', 'categorie_id' => 8, 'prix_achat' => 15000, 'prix_vente' => 25000, 'quantite_stock' => 10],
            ['nom' => 'Sac à main en toile', 'categorie_id' => 8, 'prix_achat' => 8000, 'prix_vente' => 12000, 'quantite_stock' => 12],
            ['nom' => 'Pochette élégante soirée', 'categorie_id' => 8, 'prix_achat' => 7000, 'prix_vente' => 11000, 'quantite_stock' => 8],
            ['nom' => 'Sac bandoulière Zara', 'categorie_id' => 8, 'prix_achat' => 12000, 'prix_vente' => 18000, 'quantite_stock' => 6],
            ['nom' => 'Sac à main Louis Vuitton (réplique)', 'categorie_id' => 8, 'prix_achat' => 20000, 'prix_vente' => 30000, 'quantite_stock' => 5],

            // Chaussures (catégorie_id = 4)
            ['nom' => 'Baskets Nike Air Force 1', 'categorie_id' => 4, 'prix_achat' => 28000, 'prix_vente' => 35000, 'quantite_stock' => 8],
            ['nom' => 'Talons aiguilles femme', 'categorie_id' => 4, 'prix_achat' => 15000, 'prix_vente' => 22000, 'quantite_stock' => 6],
            ['nom' => 'Sandales cuir homme', 'categorie_id' => 4, 'prix_achat' => 10000, 'prix_vente' => 15000, 'quantite_stock' => 10],
            ['nom' => 'Mocassins élégants', 'categorie_id' => 4, 'prix_achat' => 12000, 'prix_vente' => 18000, 'quantite_stock' => 7],
            ['nom' => 'Tennis Vans Classic', 'categorie_id' => 4, 'prix_achat' => 18000, 'prix_vente' => 25000, 'quantite_stock' => 5],

            // Vêtements (catégorie_id = 3)
            ['nom' => 'T-shirt unisexe coton', 'categorie_id' => 3, 'prix_achat' => 3000, 'prix_vente' => 6000, 'quantite_stock' => 20],
            ['nom' => 'Pantalon jeans slim', 'categorie_id' => 3, 'prix_achat' => 8000, 'prix_vente' => 12000, 'quantite_stock' => 10],
            ['nom' => 'Robe de soirée', 'categorie_id' => 3, 'prix_achat' => 15000, 'prix_vente' => 25000, 'quantite_stock' => 6],
            ['nom' => 'Chemise homme manches longues', 'categorie_id' => 3, 'prix_achat' => 9000, 'prix_vente' => 13000, 'quantite_stock' => 8],
            ['nom' => 'Veste légère femme', 'categorie_id' => 3, 'prix_achat' => 12000, 'prix_vente' => 18000, 'quantite_stock' => 5],

            // Bijoux et montres (catégorie_id = 2)
            ['nom' => 'Collier doré fantaisie', 'categorie_id' => 2, 'prix_achat' => 2500, 'prix_vente' => 5000, 'quantite_stock' => 15],
            ['nom' => 'Bracelet perles naturelles', 'categorie_id' => 2, 'prix_achat' => 2000, 'prix_vente' => 4000, 'quantite_stock' => 20],
            ['nom' => 'Boucles d’oreilles argentées', 'categorie_id' => 2, 'prix_achat' => 3000, 'prix_vente' => 6000, 'quantite_stock' => 12],
            ['nom' => 'Bague acier inoxydable', 'categorie_id' => 2, 'prix_achat' => 2500, 'prix_vente' => 5000, 'quantite_stock' => 10],
            ['nom' => 'Montre bracelet femme élégante', 'categorie_id' => 2, 'prix_achat' => 7000, 'prix_vente' => 12000, 'quantite_stock' => 5],
        ];

        foreach ($produits as $p) {
            Produit::create([
                'nom' => $p['nom'],
                'categorie_id' => $p['categorie_id'],
                'prix_achat' => $p['prix_achat'],
                'prix_vente' => $p['prix_vente'],
                'quantite_stock' => $p['quantite_stock'],
                'cabine_id' => 2,
            ]);
        }
    }
}
