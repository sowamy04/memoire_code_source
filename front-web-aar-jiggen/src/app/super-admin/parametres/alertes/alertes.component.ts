
import { Component, OnInit } from '@angular/core';
import { AlerteService } from '../../services/alerte.service';

@Component({
  selector: 'app-alertes',
  templateUrl: './alertes.component.html',
  styleUrls: ['./alertes.component.scss']
})
export class AlertesComponent implements OnInit {

  alertes : any
  i : any
  tab : any[] = []
  constructor( private alerteService : AlerteService ) { }

  ngOnInit(): void {
    this.showAlertes()
  }

  showAlertes(){
    this.alerteService.listealertes().subscribe(
      (resultat : any) =>{
        console.log(resultat)
        this.i = 0
        for (let index = 0; index < resultat.length; index++) {
          if (resultat[index].statut == true) {
            this.tab[this.i] = resultat[index]
            this.i++
          }
        }
        this.alertes = resultat
      },
      (error : any) => console.log ('Erreur lors du chargement', error)
    )
  }

}
