import { AdminService } from './../../services/admin.service';
import { FormControl, Validators, FormGroup } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-add-admin',
  templateUrl: './add-admin.component.html',
  styleUrls: ['./add-admin.component.scss']
})
export class AddAdminComponent implements OnInit {

  hide=true;
  email = new FormControl('', [
    Validators.required,
    Validators.email,
  ]);
  adminForm : FormGroup | any
  file : any

  constructor(private adminService : AdminService) { }

  ngOnInit(): void {
    this.adminForm = new FormGroup({
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

  ajouterAdmin(){
    console.log(this.adminForm.value)
    const formData  = new FormData()
    formData.append("prenom", this.adminForm.value.prenom)
    formData.append("nom", this.adminForm.value.nom)
    formData.append("email", this.adminForm.value.email)
    formData.append("password", this.adminForm.value.password)
    formData.append("telephone", this.adminForm.value.telephone)
    if (this.file) {
      formData.append('photo', this.file);
    }
    console.log(formData)
    this.adminService.ajouterAdmin(formData).subscribe(
      (response : any)=> {
        console.log(response)
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Nouveau admin ajouté avec succès',
          showConfirmButton: false,
          timer: 1500
        })

      },
      error=> console.log(error)
    )
  }


  onFileSelected(){

  }

}
