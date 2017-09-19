<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super = new Role();
        $super->name = 'super-admin';
        $super->type = 'super_admin';
        $super->display_name = 'super administrateur';
        $super->description = 'l\'utilisateur est autorisé à diriger et éditer d\'autres utilisateurs et les articles';
        $super->save();

        $admin = new Role();
        $admin->name = 'administrator';
        $super->type = 'admin';
        $admin->display_name = 'Administrateur';
        $admin->description = 'l\'utilisateur est juste autorisé à tout observer';
        $admin->save();

        /*********************
         **** STOCK ROLES ****
        **********************/
        $stock_permissions = [
            [
                'name' => 'new_stock',
                'type' => 'stock',
                'display_name' => 'creation',
                'description' => "L\'utilisateur est habilité à creer des nouveaux stock"
            ],
            [
                'name' => 'edit',
                'type' => 'stock',
                'display_name' => "modifier",
                'description' => "L\'utilisateur est habilité à modifier les stock existant"
            ],
            [
                'name' => 'output',
                'type' => 'stock',
                'display_name' => 'Sortie de pieces',
                'description' => "L\'utilisateur est habilité à sortir les pieces du stock"
            ],
            [
                'name' => 'input_stock',
                'type' => 'stock',
                'display_name' => 'entrer de pieces',
                'description' => "L\'utilisateur est habilité à faire une entrée de nouvelle pieces dans le stock"
            ],
            [
                'name' => 'return_stock',
                'type' => 'stock',
                'display_name' => 'retour de pieces',
                'description' => "L\'utilisateur est habilité à faire un retour de pieces dans le stock"
            ],
            [
                'name' => 'list_stck',
                'type' => 'stock',
                'display_name' => 'liste',
                'description' => "L\'utilisateur est habilité à voir la liste de stock"
            ],
            [
                'name' => 'delivery_stock',
                'type' => 'stock',
                'display_name' => 'bon de livraison',
                'description' => "L\'utilisateur est habilité à enregistrer les bons de livraison"
            ],
            [
                'name' => 'inventory_stock',
                'type' => 'stock',
                'display_name' => 'inventaire',
                'description' => "L\'utilisateur est habilité à faire l'inventaire du stock"
            ],
            [
                'name' => 'add_supplier',
                'type' => 'supplier',
                'display_name' => 'nouveau',
                'description' => "L\'utilisateur est habilité à enregistrer des fournisseur"
            ],
            [
                'name' => 'edit_supplier',
                'type' => 'supplier',
                'display_name' => 'modifier',
                'description' => "L\'utilisateur est habilité à modifier les fournisseur"
            ],
            [
                'name' => 'info_supplier',
                'type' => 'supplier',
                'display_name' => 'informations',
                'description' =>"L\'utilisateur est habilité à consulter les informations sur les fournisseurs"
            ],
        ];
        foreach ($stock_permissions as $key => $permission) {
            Permission::create($permission);
        }
        /***** END ****/


        /*********************
         **** BUS ROLES ****
         **********************/
        $buses = [
            [
                'name' => 'new_bus',
                'type' => 'bus',
                'display_name' => 'enregistrer',
                'description' => "L\'utilisateur est habilité à enregistrer de nouveaux car"
            ],
            [
                'name' => 'edit_bus',
                'type' => 'bus',
                'display_name' => "modifier",
                'description' => "L\'utilisateur est habilité à modifier les car existant"
            ],
            [
                'name' => 'list_bus',
                'type' => 'bus',
                'display_name' => 'liste',
                'description' => "L\'utilisateur est habilité à consulter la liste des cars"
            ],
            [
                'name' => 'edit_assurance',
                'type' => 'bus',
                'display_name' => 'mis a jour des assurances',
                'description' => "L\'utilisateur est habilité à faire une mis a jour des assurances de cars"
            ],
            [
                'name' => 'visit_bus',
                'type' => 'bus',
                'display_name' => 'visite technique',
                'description' => "L\'utilisateur est habilité à consulter les visites techniques des cars"
            ],
        ];
        foreach ($buses as $key => $bus) {
            Role::create($bus);
        }
        /***** END ****/


        /*********************
         **** APPROVAL ROLES ****
         **********************/
        $approvals = [
            [
                'name' => 'piece_waiting',
                'type' => 'approval',
                'display_name' => 'sortie de piece',
                'description' => "L\'utilisateur est habilité à donner l'orde de sortie de pieces"
            ],
            [
                'name' => 'piece_validate',
                'type' => 'approval',
                'display_name' => "liste des demandes validées",
                'description' => "L\'utilisateur est habilité à consulter la liste des demandes approvées"
            ],
            [
                'name' => 'authorization_repair',
                'type' => 'approval',
                'display_name' => 'sortie du car apres une réparation',
                'description' => "L\'utilisateur est habilité à donner l'autorisation de sortie des cars du garage, aprés une réparation"
            ],
            [
                'name' => 'authorization_revision',
                'type' => 'approval',
                'display_name' => 'sortie du car apres une revision',
                'description' => "L\'utilisateur est habilité à donner l'autorisation de sortie des cars du garage, aprés une revision"
            ],
            [
                'name' => 'authorization_visit',
                'type' => 'approval',
                'display_name' => 'sortie du car apres une visite technique',
                'description' => "L\'utilisateur est habilité à donner l'autorisation de sortie des cars du garage, aprés une visite technique"
            ],
        ];
        foreach ($approvals as $key => $approval) {
            Role::create($approval);
        }
        /***** END ****/

        /*********************
         **** AFTER WORKS ROLES ****
         **********************/
        $afterWorks = [
            [
                'name' => 'after_reparation',
                'type' => 'after_work',
                'display_name' => 'Essais apres travaux de réparation',
                'description' => "L\'utilisateur est habilité à donner son approbation sur les travaux de réparation"
            ],
            [
                'name' => 'after_revision',
                'type' => 'after_work',
                'display_name' => 'Essais apres travaux de revision',
                'description' => "L\'utilisateur est habilité à donner son approbation sur les travaux de revision"
            ],
            [
                'name' => 'after_visit',
                'type' => 'after_work',
                'display_name' => 'Essais apres travaux de visite technique',
                'description' => "L\'utilisateur est habilité à donner son approbation sur les travaux de visite technique"
            ],
        ];
        foreach ($afterWorks as $key => $afterWork) {
            Role::create($afterWork);
        }
        /***** END ****/

    }
}
