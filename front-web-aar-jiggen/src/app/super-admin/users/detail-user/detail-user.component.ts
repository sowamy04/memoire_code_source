import { ActivatedRoute } from '@angular/router';
import { Component, OnInit } from '@angular/core';
import { UserService } from '../../services/user.service';

@Component({
  selector: 'app-detail-user',
  templateUrl: './detail-user.component.html',
  styleUrls: ['./detail-user.component.scss']
})
export class DetailUserComponent implements OnInit {

  id : any
  data : any
  constructor( private userService : UserService, private route : ActivatedRoute ) { }

  ngOnInit(): void {
    this.id = this.route.snapshot.params['id']
    this.getUser()
  }

  getUser(){
    this.userService.afficherUser(this.id).subscribe(
      (resultat : any) => {
        console.log(resultat)
        this.data = resultat
      },
      error => console.log('Erreur lors de la récupération des informations de l\'utilisateur', error)
    )
  }

  transform(image: string){
    if(image){
      return "data:image/jpg;base64," + image
    }
    return "../../../assets/images/identification.png";
  }


}
