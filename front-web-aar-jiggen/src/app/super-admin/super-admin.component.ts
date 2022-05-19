import { UserService } from './services/user.service';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Location } from '@angular/common';
import { Router } from '@angular/router';
import { GenerationTokenService } from './../services/generation-token.service';
import { BreakpointObserver } from '@angular/cdk/layout';
import { Component, OnInit, ViewChild } from '@angular/core';
import { MatSidenav } from '@angular/material/sidenav';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-super-admin',
  templateUrl: './super-admin.component.html',
  styleUrls: ['./super-admin.component.scss'],
  providers : [UserService]
})
export class SuperAdminComponent implements OnInit {

  @ViewChild(MatSidenav)
  sidenav!: MatSidenav;
  tokenData : any
  id : any
  data : any
  helper = new JwtHelperService()
  constructor(private observer: BreakpointObserver, private auth : GenerationTokenService, private route : Router,
      private location : Location, private userService : UserService
    ) {}

  ngOnInit(): void {
    this.getInfo()
  }

  transform(image: string){
    if(image){
      return "data:image/jpg;base64," + image
    }
    return "../../../assets/images/identification.png";
  }

  getInfo(){
    this.tokenData = this.auth.RecuperationToken()
    //console.log(this.tokenData)
    const decodedToken = this.helper.decodeToken( this.tokenData);
    //console.log(decodedToken)
    this.id = decodedToken.id
    console.log(this.id)
    this.userService.afficherSuperAdmin(this.id).subscribe(
      (result : any)=>{
        this.data = result
        console.log(result)
      },
      (error:any) => console.log(error)
    )
  }

  ngAfterViewInit() {
    this.observer.observe(['(max-width: 800px)']).subscribe((res) => {
      if (res.matches) {
        this.sidenav.mode = 'over';
        this.sidenav.close();
      } else {
        this.sidenav.mode = 'side';
        this.sidenav.open();
      }
    });
  }

  deconnexion(){
    Swal.fire({
      title: 'Voulez-vous vraiment quitter?',
      showDenyButton: true,
      showCancelButton: false,
      confirmButtonText: `Oui`,
      denyButtonText: `Annuler`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        const val = this.auth.logout()
        this.route.navigateByUrl('connexion')
      } else if (result.isDenied) {
        this.location.back()
      }
    })
  }

}
