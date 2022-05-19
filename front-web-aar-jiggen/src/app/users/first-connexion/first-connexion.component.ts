import { Router } from '@angular/router';
import { AdminService } from './../../super-admin/services/admin.service';
import Swal from 'sweetalert2';
import { UserService } from './../../super-admin/services/user.service';
import { JwtHelperService } from '@auth0/angular-jwt';
import { GenerationTokenService } from './../../services/generation-token.service';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-first-connexion',
  templateUrl: './first-connexion.component.html',
  styleUrls: ['./first-connexion.component.scss']
})
export class FirstConnexionComponent implements OnInit {

  hide = true
  firstConnexionForm : FormGroup | any
  file : any
  tokenData : any
  helper = new JwtHelperService()
  id : any
  data : any
  email = new FormControl('', [
    Validators.required,
    Validators.email,
  ]);
  constructor( private auth : GenerationTokenService, private userService : UserService, private adminService : AdminService,
                private route : Router
    ) { }

  ngOnInit(): void {
    this.getInfo()
    this.firstConnexionForm = new FormGroup({
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

  modifierInfo(){
    console.log(this.firstConnexionForm.value)
    const formData  = new FormData()
    formData.append("prenom", this.firstConnexionForm.value.prenom)
    formData.append("nom", this.firstConnexionForm.value.nom)
    formData.append("email", this.firstConnexionForm.value.email)
    formData.append("password", 'pass1234')
    formData.append("telephone", this.firstConnexionForm.value.telephone)
    if (this.file) {
      formData.append('photo', this.file);
    }
    console.log(formData)
    this.adminService.modifierUser(this.id, formData).subscribe(
      (resultat : any) => {
        console.log(resultat)
        Swal.fire('Informations modifiées avec succès!', '', 'success')
        const val = this.auth.logout()
        this.route.navigateByUrl('connexion')
      },
      error => console.log('Erreur lors de la modification!', error)
    )
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
    this.userService.afficherAdmin(this.id).subscribe(
      (result : any)=>{
        this.data = result
        console.log(result)
      },
      error=> console.log(error)
    )
  }

}
