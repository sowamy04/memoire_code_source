import { AvisService } from './../../services/avis.service';
import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-avis',
  templateUrl: './avis.component.html',
  styleUrls: ['./avis.component.scss']
})
export class AvisComponent implements OnInit {

  cols: any[] = [];
  _selectedColumns: any[] = [];

  avis : any[] = []
  i : any
  tab : any[] = []
  constructor( private avisService : AvisService ) { }

  ngOnInit(): void {
    this.cols = [
      { field: 'vol', header: 'Vol' },
      { field: 'viol', header: 'Viol' },
      { field: 'agression', header: 'Agression' },
      { field: 'transport', header: 'Transport' },
      { field: 'eclairagePublique', header: 'Eclairage publique' },
      { field: 'description', header: 'Description' },
      { field: 'qualiteRoute', header: 'Qualité route' }
  ];

  this._selectedColumns = this.cols;
  this.getAvis()
  }

  getAvis(){
    this.avisService.listeAvis().subscribe(
      (resultat : any) => {
        console.log(resultat)
        this.i = 0
        for (let index = 0; index < resultat.length; index++) {
          if (resultat[index].statut == true) {
            this.tab[this.i] = resultat[index]
            this.i++
          }
        }
        this.avis = this.tab
      },
      error => console.log('Erreur lors du chargement', error)
    )
  }

  transform(image: string){
    if(image){
      return "data:image/jpg;base64," + image
    }
    return "../../../assets/images/identification.png";
  }

  @Input() get selectedColumns(): any[] {
    return this._selectedColumns;
  }

set selectedColumns(val: any[]) {
    //restore original order
    this._selectedColumns = this.cols.filter(col => val.includes(col));
}

}
