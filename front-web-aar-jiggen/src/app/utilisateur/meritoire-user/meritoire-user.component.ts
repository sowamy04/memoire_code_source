import { UserService } from './../../super-admin/services/user.service';
import { GenerationTokenService } from './../../services/generation-token.service';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-meritoire-user',
  templateUrl: './meritoire-user.component.html',
  styleUrls: ['./meritoire-user.component.scss']
})
export class MeritoireUserComponent implements OnInit {

  meritoires = [];
  tokenData : any
  id : any
  helper = new JwtHelperService()
  constructor( private auth : GenerationTokenService, private userService : UserService ) { }

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
        this.meritoires = result.personneConfiances
        console.log(result)
      },
      error=> console.log(error)
    )
  }

}
