import { OrganesService } from './../../../../services/organes.service';
import { Component, OnInit } from '@angular/core';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-organes',
  templateUrl: './organes.component.html',
  styleUrls: ['./organes.component.scss']
})
export class OrganesComponent implements OnInit {

  organes : any
  constructor( private organeService : OrganesService ) { }

  ngOnInit(): void {
    this.showOrganes()
  }

  showOrganes(){
    this.organeService.listeOrganes().subscribe(
      (resultat : any) => {
        console.log (resultat)
        this.organes = resultat
      },
      error => console.log ('Erreur lors du chargement', error)
    )
  }

  supprimer(organe:any){
    console.log(organe)
    Swal.fire({
      title: 'veut-tu vraiment supprimer cet organe?',
      showDenyButton: true,
      showCancelButton: false,
      confirmButtonText: `Supprimer`,
      denyButtonText: `Annuler`,
    }).then((result) => {
      if (result.isConfirmed) {
        this.organeService.deleteOrgane(organe.id).subscribe(
          (result : any)=>{
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Organe supprimé avec succès',
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
