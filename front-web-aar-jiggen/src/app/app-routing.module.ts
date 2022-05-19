import { InfoUserComponent } from './utilisateur/info-user/info-user.component';
import { InfoAdminComponent } from './users/info-admin/info-admin.component';
import { FirstConnexionComponent } from './users/first-connexion/first-connexion.component';
import { ChartComponent } from './super-admin/regions/departements/villes/quartiers/statisqtiques/chart/chart.component';
import { DetailUserComponent } from './super-admin/users/detail-user/detail-user.component';
import { NotFoundComponent } from './not-found/not-found.component';
import { TokenGuard } from './guard/token.guard';
import { StatsVillesComponent } from './utilisateur/stats-villes/stats-villes.component';
import { AddAvisComponent } from './utilisateur/avis-user/add-avis/add-avis.component';
import { AvisUserComponent } from './utilisateur/avis-user/avis-user.component';
import { ItineraireUserComponent } from './utilisateur/itineraire-user/itineraire-user.component';
import { AlerteUserComponent } from './utilisateur/alerte-user/alerte-user.component';
import { MeritoireUserComponent } from './utilisateur/meritoire-user/meritoire-user.component';
import { UtilisateurComponent } from './utilisateur/utilisateur.component';
import { AdminComponent } from './admin/admin.component';
import { EditOrgComponent } from './super-admin/regions/departements/villes/organes/edit-org/edit-org.component';
import { AddOrgComponent } from './super-admin/regions/departements/villes/organes/add-org/add-org.component';
import { EditQuartierComponent } from './super-admin/regions/departements/villes/quartiers/edit-quartier/edit-quartier.component';
import { AddQuartierComponent } from './super-admin/regions/departements/villes/quartiers/add-quartier/add-quartier.component';
import { EditVilleComponent } from './super-admin/regions/departements/villes/edit-ville/edit-ville.component';
import { AddVilleComponent } from './super-admin/regions/departements/villes/add-ville/add-ville.component';
import { EditDeptComponent } from './super-admin/regions/departements/edit-dept/edit-dept.component';
import { AddDeptComponent } from './super-admin/regions/departements/add-dept/add-dept.component';
import { EditRegionComponent } from './super-admin/regions/edit-region/edit-region.component';
import { AddRegionComponent } from './super-admin/regions/add-region/add-region.component';
import { AdminsComponent } from './super-admin/users/admins/admins.component';
import { InfoPersonnelComponent } from './super-admin/users/info-personnel/info-personnel.component';
import { AlertesComponent } from './super-admin/parametres/alertes/alertes.component';
import { StatisqtiquesComponent } from './super-admin/regions/departements/villes/quartiers/statisqtiques/statisqtiques.component';
import { AvisComponent } from './super-admin/parametres/avis/avis.component';
import { ItinerairesComponent } from './super-admin/parametres/itineraires/itineraires.component';
import { MeritoiresComponent } from './super-admin/parametres/meritoires/meritoires.component';
import { ProfilsComponent } from './super-admin/profils/profils.component';
import { UsersComponent } from './super-admin/users/users.component';
import { OrganesComponent } from './super-admin/regions/departements/villes/organes/organes.component';
import { QuartiersComponent } from './super-admin/regions/departements/villes/quartiers/quartiers.component';
import { VillesComponent } from './super-admin/regions/departements/villes/villes.component';
import { DepartementsComponent } from './super-admin/regions/departements/departements.component';
import { RegionsComponent } from './super-admin/regions/regions.component';
import { AddAdminComponent } from './super-admin/users/add-admin/add-admin.component';
import { SuperAdminComponent } from './super-admin/super-admin.component';
import { InscriptionComponent } from './inscription/inscription.component';
import { ConnexionComponent } from './connexion/connexion.component';
import { NgModule, Component } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  { path:'', redirectTo:'connexion', pathMatch:'full'},
  { path:'connexion', component:ConnexionComponent},
  { path:'inscription', component:InscriptionComponent},
  { path:'super-admin', component:SuperAdminComponent, canActivate :[
    TokenGuard
  ] ,children:[
    { path:'add-admin', component:AddAdminComponent },
    { path:'regions', component: RegionsComponent, children : [
        { path: 'add-region', component: AddRegionComponent},
        { path: ':id/update', component: EditRegionComponent }
      ]
    },
    { path:'depts', component: DepartementsComponent, children : [
        { path: 'add-dept', component: AddDeptComponent},
        { path: ':id/update', component: EditDeptComponent }
      ]
    },
    { path:'villes', component: VillesComponent, children : [
        { path: 'add-ville', component: AddVilleComponent},
        { path: ':id/update', component: EditVilleComponent }
      ]
    },
    { path:'quartiers', component:QuartiersComponent, children : [
        { path: 'add-quartier', component: AddQuartierComponent},
        { path: ':id/update', component: EditQuartierComponent }
      ]
    },
    { path:'organes', component: OrganesComponent, children : [
        { path: 'add-organe', component: AddOrgComponent},
        { path: ':id/update', component: EditOrgComponent }
      ]
    },
    { path:'users', component: UsersComponent, children :[
        {path:':id/detail', component: DetailUserComponent}
      ]
    },
    { path:'profils', component: ProfilsComponent },
    { path:'meritoires', component: MeritoiresComponent },
    { path:'itineraires', component: ItinerairesComponent },
    { path:'avis', component: AvisComponent },
    { path:'stats', component: StatisqtiquesComponent, children : [
       { path:':id/chart', component: ChartComponent}
    ] },
    { path:'alertes', component: AlertesComponent },
    { path:'infos', component:InfoPersonnelComponent },
    { path: 'admins', component: AdminsComponent }
    ]
  },


  { path: 'admin', component: AdminComponent, canActivate: [
    TokenGuard
  ] ,children:[
    { path:'regions', component: RegionsComponent, children : [
        { path: 'add-region', component: AddRegionComponent},
        { path: ':id/update', component: EditRegionComponent }
      ]
      },
      { path:'depts', component: DepartementsComponent, children : [
          { path: 'add-dept', component: AddDeptComponent},
          { path: ':id/update', component: EditDeptComponent }
        ]
      },
      { path:'villes', component: VillesComponent, children : [
          { path: 'add-ville', component: AddVilleComponent},
          { path: ':id/update', component: EditVilleComponent }
        ]
      },
      { path:'quartiers', component:QuartiersComponent, children : [
          { path: 'add-quartier', component: AddQuartierComponent},
          { path: ':id/update', component: EditQuartierComponent }
        ]
      },
      { path:'organes', component: OrganesComponent, children : [
          { path: 'add-organe', component: AddOrgComponent},
          { path: ':id/update', component: EditOrgComponent }
        ]
      },
      { path:'avis', component: AvisComponent },
      { path:'stats', component: StatisqtiquesComponent, children:[
        { path:':id/chart', component: ChartComponent}
      ] },
      { path:'infos', component:InfoAdminComponent },
    ]
  },

  { path:'first-connexion', component: FirstConnexionComponent },


  { path:'users', component: UtilisateurComponent, canActivate:[
    TokenGuard
    ] ,children : [
    { path:'meritoires', component:MeritoireUserComponent },
    { path:'alertes', component: AlerteUserComponent },
    { path:'itineraires', component: ItineraireUserComponent },
    { path:'avis', component: AvisUserComponent, children: [
      { path:'add-avis', component: AddAvisComponent }
    ] },
    { path:'stats', component: StatsVillesComponent, children:[
      { path:':id/chart', component: ChartComponent}
    ] },
    { path:'infos', component:InfoUserComponent },
  ] },

  { path:'not-found', component:NotFoundComponent },
  { path:'**', redirectTo:'not-found'}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
