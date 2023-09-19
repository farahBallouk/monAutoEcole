<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class RoleAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $create_profile= Permission:: create(['name'=> 'create_profile']);
        $edit_profile= Permission:: create(['name'=> 'edit_profile']);
         $supprimer_profile= Permission:: create(['name'=> 'supprimer_profile']);
         $voir_profile= Permission:: create(['name'=> 'voir_profile']);
        $ajouter_candidat= Permission:: create(['name'=> 'ajouter_candidat']);
        $modifier_candidat= Permission:: create(['name'=> 'modifier_candidat']);
        $supprimer_candidat= Permission:: create(['name'=> 'supprimer_candidat']);
        $list_candidats= Permission:: create(['name'=> 'list_candidats']);
        $affiche_candidat= Permission:: create(['name'=> 'affiche_candidat']);
        $planifier_calendrier= Permission:: create(['name'=> 'planifier_calendrier']);
        $choisir_vehicule= Permission:: create(['name'=> 'choisir_vehicule']);
        $choisir_moniteur= Permission:: create(['name'=> 'choisir_moniteur']);
        $list_reservations= Permission:: create(['name'=> 'list_reservations']);
        $accepter_reservation= Permission:: create(['name'=> 'accepter_reservation']);
        $refuser_reservation= Permission:: create(['name'=> 'refuser_reservation']);
        $reporter_reservation= Permission:: create(['name'=> 'reporter_reservation']);
        $planifier_examen= Permission:: create(['name'=> 'planifier_examen']);
        $affiche_noteExamen= Permission:: create(['name'=> 'affiche_noteExamen']);
        $ajouter_test= Permission:: create(['name'=> 'ajouter_test']);
        $supprimer_test= Permission:: create(['name'=> 'supprimer_test']);
        $modifier_test= Permission:: create(['name'=> 'modifier_test']);
        $voir_reponsesTest= Permission:: create(['name'=> 'voir_reponsesTest']);
        $corriger_test= Permission:: create(['name'=> 'corriger_test']);
        $ajouter_publication= Permission:: create(['name'=> 'ajouter_publication']);
        $modifier_publication= Permission:: create(['name'=> 'modifier_publication']);
        $supprimer_publication= Permission:: create(['name'=> 'supprimer_publication']);
        $passer_test= Permission:: create(['name'=> 'passer_test']);
        $apprendre_cours= Permission:: create(['name'=> 'apprendre_cours']);
        $demander_reservation= Permission:: create(['name'=> 'demander_reservation']);
        $annuler_reservation= Permission:: create(['name'=> 'annuler_reservation']);
        $contacter_support= Permission:: create(['name'=> 'contacter_support']);
        $voir_noteExamen= Permission:: create(['name'=> 'voir_noteExamen']);
        $demander_reporterExamen= Permission:: create(['name'=> 'demander_reporterExamen']);
        $consulter_reservation= Permission:: create(['name'=> 'consulter_reservation']);
        $consulter_calendrier= Permission:: create(['name'=> 'consulter_calendrier']);
        $ajouter_evaluation= Permission:: create(['name'=> 'ajouter_evaluation']);
        $affecte_candidat_to_auto= Permission:: create(['name'=> 'affecte_candidat_to_auto']);
       
        $superadmin_role = Role::create(['name' => 'superadmin']);
        $superadmin_role->givePermissionTo([
            $create_profile,
            $edit_profile,
            $supprimer_profile,
            $voir_profile,
            $ajouter_candidat,
            $modifier_candidat,
            $supprimer_candidat,
            $list_candidats,
            $affiche_candidat,
            $planifier_calendrier,
            $choisir_vehicule,
            $choisir_moniteur,
            $list_reservations,
            $accepter_reservation,
            $refuser_reservation,
            $reporter_reservation,
            $planifier_examen,
            $affiche_noteExamen,
            $ajouter_test,
            $supprimer_test,
            $modifier_test,
            $voir_reponsesTest,
            $corriger_test,
            $ajouter_publication,
            $modifier_publication,
            $supprimer_publication,
            $passer_test,
            $apprendre_cours,
            $demander_reservation,
            $annuler_reservation,
            $voir_noteExamen,
            $affecte_candidat_to_auto,
            $inscrir_candidat
          

        ]);

        $autoEcole_role = Role::create(['name' => 'autoEcole']);

        $autoEcole_role->givePermissionTo([
            $create_profile,
            $edit_profile,
            $supprimer_profile,
            $voir_profile,
            $ajouter_candidat,
            $modifier_candidat,
            $supprimer_candidat,
            $list_candidats, 
            $affiche_candidat,
            $planifier_calendrier,
            $choisir_vehicule,
            $choisir_moniteur,
            $list_reservations,
            $accepter_reservation,
            $refuser_reservation,
            $reporter_reservation,
            $planifier_examen,
            $affiche_noteExamen,
            $ajouter_test,
            $supprimer_test,
            $modifier_test,
            $voir_reponsesTest,
            $corriger_test,
            $ajouter_publication,
            $modifier_publication,
            $supprimer_publication,
            $contacter_support
            
           
        ]);

        $candidat_role = Role::create(['name' => 'candidat']);

        $candidat_role->givePermissionTo([
            $passer_test,
            $create_profile,
            $edit_profile,
            $supprimer_profile,
            $voir_profile,
            $apprendre_cours,
            $demander_reservation,
            $annuler_reservation,
            $contacter_support,
            $voir_noteExamen,
            $demander_reporterExamen,
           
        ]);

        $moniteur_role = Role::create(['name' => 'moniteur']);

      //  $moniteur->assignRole($moniteur_role);
    
        $moniteur_role->givePermissionTo([
            $consulter_reservation,
            $create_profile,
            $edit_profile,
            $supprimer_profile,
            $voir_profile,
            $consulter_calendrier,
            $ajouter_evaluation
           
        ]);


    }
}
