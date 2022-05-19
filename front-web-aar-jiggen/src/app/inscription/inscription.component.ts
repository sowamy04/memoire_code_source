import { Router } from '@angular/router';
import { Location } from '@angular/common';
import { UserService } from './../super-admin/services/user.service';
import { FormControl, Validators, FormGroup } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-inscription',
  templateUrl: './inscription.component.html',
  styleUrls: ['./inscription.component.scss']
})
export class InscriptionComponent implements OnInit {

  hide=true;
  email = new FormControl('', [
    Validators.required,
    Validators.email,
  ]);
  userForm : FormGroup | any
  file : any
  constructor( private userService : UserService, private location : Location, private route : Router ) { }

  ngOnInit(): void {
    this.userForm = new FormGroup({
      prenom : new FormControl('', Validators.required),
      nom : new FormControl('', Validators.required),
      telephone : new FormControl('', Validators.required),
      password : new FormControl('', Validators.required),
      genre : new FormControl('', Validators.required),
      adresse : new FormControl('', Validators.required),
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

  ajouterUtilisateur(){
    console.log(this.userForm.value)
    const formData  = new FormData()
    formData.append("prenom", this.userForm.value.prenom)
    formData.append("nom", this.userForm.value.nom)
    formData.append("email", this.userForm.value.email)
    formData.append("password", this.userForm.value.password)
    formData.append("telephone", this.userForm.value.telephone)
    formData.append("sexe", this.userForm.value.genre)
    formData.append("adresse", this.userForm.value.adresse)
    if (this.file) {
      formData.append('photo', this.file);
    }
    console.log(formData)

    this.userService.ajouterUtilisateur(formData).subscribe(
      (resultat : any) => {
        console.log(resultat)
        Swal.fire('Inscription avec succès!', '', 'success')
        this.route.navigateByUrl('/connexion')
      },
      error => console.log('Erreur lors de la modification!', error)
    )
  }

}
