import Swal from 'sweetalert2';
import { QuartierService } from './../../../../services/quartier.service';
import { Table } from 'primeng/table';
import { Component, OnInit, ViewChild } from '@angular/core';

@Component({
  selector: 'app-quartiers',
  templateUrl: './quartiers.component.html',
  styleUrls: ['./quartiers.component.scss']
})
export class QuartiersComponent implements OnInit {

  quartiers : any[] = [];

  productDialog : any = false;

  product: any;

  selectedProducts: any;

  any: any;

  submitted: boolean = false;

  statuses: any;
  i: any
  tab : any[] = []

  @ViewChild('dt') dt: Table | any;
  constructor( private quartierService : QuartierService ) {}

  ngOnInit() {
    this.getQuartiers()
  }

  getQuartiers(){
    this.quartierService.listequartiers().subscribe(
      (resultat : any) => {
        console.log (resultat)
        this.i = 0
        for (let index = 0; index < resultat.length; index++) {
          if (resultat[index].statut == true) {
            this.tab[this.i] = resultat[index]
            this.i++
          }
        }
        this.quartiers = this.tab
      },
      error => console.log ('Erreur lors du chargement', error)
    )
  }

  applyFilterGlobal($event: any, stringVal : any) {
  this.dt.filterGlobal(($event.target as HTMLInputElement).value, stringVal);
  }

  deleteSelectedQuartiers() {

  }

  deleteQuartier(quartier: any) {
    console.log(quartier)
    Swal.fire({
      title: 'veut-tu vraiment supprimer ce quartier?',
      showDenyButton: true,
      showCancelButton: false,
      confirmButtonText: `Supprimer`,
      denyButtonText: `Annuler`,
    }).then((result : any) => {
      if (result.isConfirmed) {
        this.quartierService.deletequartier(quartier.id).subscribe(
          (result : any)=>{
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'quartier supprimée avec succès',
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

}

