import { UserService } from './../../super-admin/services/user.service';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Router } from '@angular/router';
import { Location } from '@angular/common';
import { GenerationTokenService } from './../../services/generation-token.service';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-alerte-user',
  templateUrl: './alerte-user.component.html',
  styleUrls: ['./alerte-user.component.scss']
})
export class AlerteUserComponent implements OnInit {

  alertes = []
  tokenData : any
  id : any
  helper = new JwtHelperService()
  data : any

  constructor( private auth: GenerationTokenService, private route : Router , private location : Location,
    private userService : UserService ) { }

  ngOnInit(): void {
    this.getInfo()
  }

  getInfo(){
    this.tokenData = this.auth.RecuperationToken()
    console.log(this.tokenData)
    const decodedToken = this.helper.decodeToken( this.tokenData);
    console.log(decodedToken)
    this.id = decodedToken.id
    console.log(this.id)
    this.userService.afficherUser(this.id).subscribe(
      (result : any)=>{
        this.alertes = result.alertes
        console.log(this.alertes)
      },
      error=> console.log(error)
    )
  }


}
