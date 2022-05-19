import Swal from 'sweetalert2';
import { AdminService } from './../../services/admin.service';
import { Table } from 'primeng/table';
import { Component, OnInit, ViewChild } from '@angular/core';

@Component({
  selector: 'app-admins',
  templateUrl: './admins.component.html',
  styleUrls: ['./admins.component.scss']
})
export class AdminsComponent implements OnInit {

  admins : any
  first = 0;

  rows = 5;
  selectedUsers : any

  @ViewChild('dt') dt: Table | any;
  constructor( private adminService : AdminService ) { }

  ngOnInit(): void {
    this.showAdmins()
  }

  showAdmins(){
    this.adminService.listeAdmin().subscribe(
      (resultat : any)=>{
        console.log (resultat)
        this.admins = resultat
      },
      error => console.log('Erreur lors de le récupération')
    )
  }

  transform(image: string){
    if(image){
      return "data:image/jpg;base64," + image
    }
    return "../../../assets/images/identification.png";
  }

  supprimer(admin:any){
    console.log(admin)
    Swal.fire({
      title: 'veut-tu vraiment supprimer cet admin?',
      showDenyButton: true,
      showCancelButton: false,
      confirmButtonText: `Supprimer`,
      denyButtonText: `Annuler`,
    }).then((result) => {
      if (result.isConfirmed) {
        this.adminService.supprimerAdmin(admin.id).subscribe(
          (result : any)=>{
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Administrateur supprimé avec succès',
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

  applyFilterGlobal($event: any, stringVal : any) {
    this.dt.filterGlobal(($event.target as HTMLInputElement).value, stringVal);
  }

  next() {
    this.first = this.first + this.rows;
  }

  prev() {
      this.first = this.first - this.rows;
  }

  reset() {
      this.first = 0;
  }

  isLastPage(): boolean {
      return this.admins ? this.first === (this.admins.length - this.rows): true;
  }

  isFirstPage(): boolean {
      return this.admins ? this.first === 0 : true;
  }

}
