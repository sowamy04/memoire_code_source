import { ItineraireService } from './../../services/itineraire.service';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-itineraires',
  templateUrl: './itineraires.component.html',
  styleUrls: ['./itineraires.component.scss']
})
export class ItinerairesComponent implements OnInit {

  itineraires : any[] = []
  i : any
  tab : any[] = []
  constructor( private itineraireService : ItineraireService ) { }

  ngOnInit(): void {
    this.showItineraire()
  }

  showItineraire(){
    this.itineraireService.listeItineraires().subscribe(
      (resultat : any) => {
        console.log (resultat)
        /* this.i = 0
        for (let index = 0; index < resultat.length; index++) {
          if (resultat[index].statut == true) {
            this.tab[this.i] = resultat[index]
            this.i++
          }
        } */
        this.itineraires = resultat
      },
      error => console.log ('Erreur lors du chargement', error)
    )
  }

}
