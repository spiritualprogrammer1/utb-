<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'add-user',
                'display_name' => 'ajouter un utilisateur',
                'description' => 'ajouter des utilisateurs'
            ],
            [
                'name' => 'edit-user',
                'display_name' => 'modifier un utilisateur',
                'description' => 'modification des utilisateurs'
            ],
            [
                'name' => 'delete-user',
                'display_name' => 'supprimer un utilisateur',
                'description' => 'suppression des utilisateurs'
            ],
            [
                'name' => 'add-category',
                'display_name' => 'Ajouter une category',
                'description' => 'Ajouter des categories'
            ],
            [
                'name' => 'edit-category',
                'display_name' => 'modifier une category',
                'description' => 'modification des categories'
            ],
            [
                'name' => 'delete-category',
                'display_name' => 'supprimer une category',
                'description' => 'suppression des categories'
            ],
            [
                'name' => 'add-product',
                'display_name' => 'Ajout de produit',
                'description' => 'Ajouter des nouveaux produits'
            ],
            [
                'name' => 'edit-product',
                'display_name' => 'modifier un produit',
                'description' => 'modification des produits'
            ],
            [
                'name' => 'delete-product',
                'display_name' => 'supprimer un produit',
                'description' => 'suppression des produits'
            ],
            [
                'name' => 'sell-product',
                'display_name' => 'Vente de produit',
                'description' => 'Vente des produits'
            ],
            [
                'name' => 'add-customer',
                'display_name' => 'ajouter un client',
                'description' => 'ajouter des nouveaux clients'
            ],
            [
                'name' => 'edit-customer',
                'display_name' => 'modifier un client',
                'description' => 'modification des clients'
            ],
            [
                'name' => 'delete-customer',
                'display_name' => 'supprimer un client',
                'description' => 'suppression des clients'
            ],
            [
                'name' => 'attribution-product',
                'display_name' => 'attribuer un produit',
                'description' => 'attribution des produits'
            ],
            [
                'name' => 'delete-attribution',
                'display_name' => 'supprimer une attribution',
                'description' => 'suppression des attributions'
            ],
            [
                'name' => 'edit-attribution',
                'display_name' => 'modifier une attribution',
                'description' => 'modification des attribution'
            ],
            [
                'name' => 'state',
                'display_name' => 'Voir des etats',
                'description' => 'visualiser les etats de vente'
            ],
            [
                'name' => 'delete-state',
                'display_name' => 'supprimer des etats',
                'description' => 'suppression des etats de vente'
            ],
        ];

        foreach ($permissions as $key => $permission) {
            Permission::create($permission);
        }
    }
}
