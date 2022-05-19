import { DeptService } from './../../services/dept.service';
import { Table } from 'primeng/table';
import { Component, OnInit, ViewChild } from '@angular/core';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-departements',
  templateUrl: './departements.component.html',
  styleUrls: ['./departements.component.scss'],
  styles :[`
    :host ::ng-deep .p-dialog .product-image {
      width: 150px;
      margin: 0 auto 2rem auto;
      display: block;
  }
  `]
})
export class DepartementsComponent implements OnInit {

  departements: any
  depts : any
  productDialog : any = false;
  product: any;
  selectedProducts: any;
  any: any;
  submitted: boolean = false;
  statuses: any;
  i : any
  tab : any[] = []

  @ViewChild('dt') dt: Table | any;
  constructor( private deptService : DeptService ) {
  }

  ngOnInit() {
    this.showDepts()
  }

  showDepts(){
    this.deptService.listeDept().subscribe(
      (resultat : any)=>{
        console.log (resultat)
        this.i = 0
        for (let index = 0; index < resultat.length; index++) {
          if (resultat[index].statut == true) {
            this.tab[this.i] = resultat[index]
            this.i++
          }
        }
        this.departements = this.tab
      },
      (error : any) => console.log('Erreur lors du chargement', error)
    )
  }

  supprimer(dept:any){
    console.log(dept)
    Swal.fire({
      title: 'veut-tu vraiment supprimer ce département?',
      showDenyButton: true,
      showCancelButton: false,
      confirmButtonText: `Supprimer`,
      denyButtonText: `Annuler`,
    }).then((result) => {
      if (result.isConfirmed) {
        this.deptService.delete(dept.id).subscribe(
          (result : any)=>{
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Département supprimé avec succès',
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

  applyFilterGlobal($event: any, stringVal : any) {
    this.dt.filterGlobal(($event.target as HTMLInputElement).value, stringVal);
  }

  deleteSelectedProducts() {

  }
}

