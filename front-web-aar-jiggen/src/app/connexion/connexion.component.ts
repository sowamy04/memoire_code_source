import { GenerationTokenService } from './../services/generation-token.service';
import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { JwtHelperService } from "@auth0/angular-jwt";
import { Router } from '@angular/router';

@Component({
  selector: 'app-connexion',
  templateUrl: './connexion.component.html',
  styleUrls: ['./connexion.component.scss']
})
export class ConnexionComponent implements OnInit {

  loginForm : FormGroup | any
  helper = new JwtHelperService()
  message = '';
  constructor( private auth: GenerationTokenService, private router : Router) { }

  ngOnInit(): void {
    this.isAuthenticated()
    this.loginForm = new FormGroup({
      username : new FormControl('', Validators.required),
      password : new FormControl('', Validators.required)
    });
  }

  onLogin(){
    const loginVal = this.loginForm.value
    console.log(loginVal)
      if (loginVal){
        this.auth.getToken(loginVal).subscribe(
          (response:any)=> {localStorage.setItem('token', response.token);
          const decodedToken = this.helper.decodeToken( response.token);
          console.log(decodedToken)
          if (decodedToken.statut == 1) {
            if (decodedToken.roles == "ROLE_SUPER_ADMIN") {
              this.router.navigateByUrl("/super-admin/profils")
            }
            else if (decodedToken.roles == "ROLE_ADMIN"){
              if(decodedToken.firstConnexion == true){
                this.router.navigateByUrl("/first-connexion")
              }
              else{
                this.router.navigateByUrl("/admin/regions")
              }
            }
            else{
              this.router.navigateByUrl("/users/meritoires")
            }
          }
          else{
            this.message = "Vous n'avez plus accès a cette plateforme BYE!"
          }
        },
          error=> this.message = "Email ou mot de passe incorrects!"
        )
      }
  }

  isAuthenticated(){
    const token = this.auth.RecuperationToken();
    if (token) {
      const decodedToken = this.helper.decodeToken(token);
      if (decodedToken.statut == 1) {
        if (decodedToken.roles == "ROLE_SUPER_ADMIN") {
          this.router.navigateByUrl("/super-admin/profils")
        }
        else if (decodedToken.roles == "ROLE_ADMIN"){
          if(decodedToken.firstConnexion == true){
            this.router.navigateByUrl("/admin/infos")
          }
          else{
            this.router.navigateByUrl("/admin/regions")
          }
        }
        else{
          this.router.navigateByUrl("/users/meritoires")
        }
      }
    }
  }

}
