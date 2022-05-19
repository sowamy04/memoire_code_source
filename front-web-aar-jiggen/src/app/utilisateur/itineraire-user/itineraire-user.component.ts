import { UserService } from './../../super-admin/services/user.service';
import { GenerationTokenService } from './../../services/generation-token.service';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-itineraire-user',
  templateUrl: './itineraire-user.component.html',
  styleUrls: ['./itineraire-user.component.scss']
})
export class ItineraireUserComponent implements OnInit {

  itineraires = [];
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
        this.itineraires = result.itineraires
        console.log(result)
      },
      error=> console.log(error)
    )
  }

}
