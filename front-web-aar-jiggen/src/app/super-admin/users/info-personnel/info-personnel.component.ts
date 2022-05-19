import { AdminService } from './../../services/admin.service';
import { Location } from '@angular/common';
import { UserService } from './../../services/user.service';
import { JwtHelperService } from '@auth0/angular-jwt';
import { GenerationTokenService } from './../../../services/generation-token.service';
import { Validators, FormControl, FormGroup } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-info-personnel',
  templateUrl: './info-personnel.component.html',
  styleUrls: ['./info-personnel.component.scss']
})
export class InfoPersonnelComponent implements OnInit {

  hide=true;
  hidden = false
  readonly = true
  userForm : FormGroup | any
  file : any
  email = new FormControl('', [
    Validators.required,
    Validators.email,
  ]);
  tokenData : any
  helper = new JwtHelperService()
  id : any
  data : any
  constructor( private auth : GenerationTokenService, private userService : UserService, private location : Location, private adminService : AdminService) { }

  ngOnInit(): void {
    this.getInfo()
    this.userForm = new FormGroup({
      prenom : new FormControl('', Validators.required),
      nom : new FormControl('', Validators.required),
      telephone : new FormControl('', Validators.required),
      password : new FormControl('', Validators.required),
      email : new FormControl('', [
        Validators.required,
        Validators.email,
      ])
    });
  }

  uploadFile(event : any) {
    if (event.target.files.length > 0) {
       this.file = event.target.files[0];
      console.log(this.file)
    }
  }

  transform(image: string){
    if(image){
      return "data:image/jpg;base64," + image
    }
    return "../../../assets/images/identification.png";
  }

  getInfo(){
    this.tokenData = this.auth.RecuperationToken()
    console.log(this.tokenData)
    const decodedToken = this.helper.decodeToken( this.tokenData);
    console.log(decodedToken)
    this.id = decodedToken.id
    console.log(this.id)
    this.userService.afficherSuperAdmin(this.id).subscribe(
      (result : any)=>{
        this.data = result
        console.log(result)
      },
      (error : any) => console.log(error)
    )
  }

  modifierUser(){
    console.log(this.userForm.value)
    const formData  = new FormData()
    formData.append("prenom", this.userForm.value.prenom)
    formData.append("nom", this.userForm.value.nom)
    formData.append("email", this.userForm.value.email)
    formData.append("password", 'pass1234')
    formData.append("telephone", this.userForm.value.telephone)
    if (this.file) {
      formData.append('photo', this.file);
    }
    console.log(formData)

    Swal.fire({
      title: 'Voulez-vous vraiment modifier ces informations?',
      showDenyButton: true,
      confirmButtonText: `modifier`,
      denyButtonText: `annuler`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        this.adminService.modifierUser(this.id, formData).subscribe(
          (resultat : any) => {
            console.log(resultat)
            Swal.fire('Informations modifiées avec succès!', '', 'success')
          },
          error => console.log('Erreur lors de la modification!', error)
        )
      } else if (result.isDenied) {
        Swal.fire('Modification annulée avec succès!', '', 'info')
      }
    },
      error => console.log(error)
    )
  }

  retour(){
    this.location.back()
  }

}
