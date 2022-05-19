import { VilleService } from './../../../services/ville.service';
import { Table } from 'primeng/table';
import { Component, OnInit, ViewChild } from '@angular/core';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-villes',
  templateUrl: './villes.component.html',
  styleUrls: ['./villes.component.scss']
})
export class VillesComponent implements OnInit {

 villes : any = [

];

departements : any

productDialog : any = false;

product: any;

selectedProducts: any;

any: any;

submitted: boolean = false;

statuses: any;
i : any
tab : any[] = []

  @ViewChild('dt') dt: Table | any;
  constructor( private villeService : VilleService ) {}

  ngOnInit() {
    this.getVille()
  }

  getVille(){
    this.villeService.listeVilles().subscribe(
      (resultat : any) => {
        console.log(resultat)
        this.i = 0
        for (let index = 0; index < resultat.length; index++) {
          if (resultat[index].statut == true) {
            this.tab[this.i] = resultat[index]
            this.i++
          }
        }
        this.villes = this.tab
      },
      error => console.log ('Erreur lors du chargement', error)
    )
  }

  applyFilterGlobal($event: any, stringVal : any) {
    this.dt.filterGlobal(($event.target as HTMLInputElement).value, stringVal);
  }

  deleteVille(ville : any){
    console.log(ville)
    Swal.fire({
      title: 'veut-tu vraiment supprimer cette ville?',
      showDenyButton: true,
      showCancelButton: false,
      confirmButtonText: `Supprimer`,
      denyButtonText: `Annuler`,
    }).then((result) => {
      if (result.isConfirmed) {
        this.villeService.deleteVille(ville.id).subscribe(
          (result : any)=>{
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Ville supprimée avec succès',
              showConfirmButton: false,
              timer: 1500
            })
            console.log(result)
          },
          (error : any) => console.log(error)
        )
      } else if (result.isDenied) {
        Swal.fire('Suppression annulée', '', 'info')
      }
    })

  }

  deleteSelectedVilles() {

  }

}

