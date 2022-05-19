import Swal from 'sweetalert2';
import { UserService } from './../services/user.service';
import { Table } from 'primeng/table';
import { Component, OnInit, ViewChild } from '@angular/core';

@Component({
  selector: 'app-users',
  templateUrl: './users.component.html',
  styleUrls: ['./users.component.scss']
})
export class UsersComponent implements OnInit {

  users : any
  first = 0;

  rows = 5;

  selectedUsers : any

  @ViewChild('dt') dt: Table | any;
  constructor( private userService : UserService ) { }

  ngOnInit(): void {
    this.showUsers()
  }

  showUsers(){
    this.userService.listerUtilisateurs().subscribe(
      (resultat : any)=>{
        console.log(resultat)
        this.users = resultat
      },
      error => console.log('Erreur lors du chargement!')
    )
  }

  supprimer(user : any){
    console.log(user)
    Swal.fire({
      title: 'veut-tu vraiment supprimer cet utilisateur?',
      showDenyButton: true,
      showCancelButton: false,
      confirmButtonText: `Supprimer`,
      denyButtonText: `Annuler`,
    }).then((result) => {
      if (result.isConfirmed) {
        this.userService.supprimerUser(user.id).subscribe(
          (result : any)=>{
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Utilisateur supprimé avec succès',
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

  transform(image: string){
    if(image){
      return "data:image/jpg;base64," + image
    }
    return "../../../assets/images/identification.png";
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
    return this.users ? this.first === (this.users.length - this.rows): true;
}

isFirstPage(): boolean {
    return this.users ? this.first === 0 : true;
}

}
