import Swal from 'sweetalert2';
import { Component, OnInit } from '@angular/core';
import { ProfilService } from '../services/profil.service';

@Component({
  selector: 'app-profils',
  templateUrl: './profils.component.html',
  styleUrls: ['./profils.component.scss']
})
export class ProfilsComponent implements OnInit {

  profils: any;
  id : any
  data : any

  constructor( private profilService : ProfilService ) { }

  ngOnInit(): void {
    this.showProfils()
  }

  showProfils(){
    this.profilService.listerProfils().subscribe(
      (result:any)=>{
        //console.log(result)
        this.profils = result
      },
      (error:any)=>console.log(error.error.message)
    )
  }

  getProfil(){
    this.profilService.getProfil(this.id).subscribe(
      (response : any)=>{
        console.log(response)
        this.data = response
      },
      error=> console.log(error)
    )
  }

  supprimer(profilData : any){
    /* this.id = this.routeActivated.snapshot.params['id'];
    profilData =  this.getProfil() */
    console.log(profilData)
    Swal.fire({
      title: 'veut-tu vraiment supprimer ce profil?',
      showDenyButton: true,
      showCancelButton: false,
      confirmButtonText: `Supprimer`,
      denyButtonText: `Annuler`,
    }).then((result) => {
      if (result.isConfirmed) {
        this.profilService.deleteProfil(profilData.id).subscribe(
          (result : any)=>{
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Profil supprimé avec succès',
              showConfirmButton: false,
              timer: 1500
            })
            console.log(result)
          },
          error=>console.log(error)
        )
      } else if (result.isDenied) {
        Swal.fire('Suppression annulée', '', 'info')
      }
    })
  }

}
