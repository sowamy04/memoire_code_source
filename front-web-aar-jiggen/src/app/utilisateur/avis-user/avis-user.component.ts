import { QuartiersComponent } from './../../super-admin/regions/departements/villes/quartiers/quartiers.component';
import { UserService } from './../../super-admin/services/user.service';
import { GenerationTokenService } from './../../services/generation-token.service';
import { JwtHelperService } from '@auth0/angular-jwt';
import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-avis-user',
  templateUrl: './avis-user.component.html',
  styleUrls: ['./avis-user.component.scss']
})
export class AvisUserComponent implements OnInit {

  cols: any[] = [];
  _selectedColumns: any[] = [];
  tokenData : any
  id : any
  helper = new JwtHelperService()
  avis : any[] = []
  data : any[] = []
  i : any
  quartier : any
  vol : any
  viol : any
  agression : any
  transport : any
  eclairage : any
  description : any
  qualiteRoute : any
  idAvis : any
  d : any
  constructor( private auth : GenerationTokenService, private userService : UserService ) { }

  ngOnInit(): void {
    this.getInfo()
    this.cols = [
      { field: 'nomQuartier', header: 'Quartier' },
      { field: 'vol', header: 'Vol' },
      { field: 'viol', header: 'Viol' },
      { field: 'agression', header: 'Agression' },
      { field: 'transport', header: 'Transport' },
      { field: 'eclairagePublique', header: 'Eclairage publique' },
      { field: 'description', header: 'Description' },
      { field: 'qualiteRoute', header: 'Qualité route' }
  ];

  this._selectedColumns = this.cols;

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
        this.data = result.avis
        console.log(this.data)
        this.i = 0
        for (let index = 0; index < this.data.length; index++) {
          this.quartier = this.data[index].quartier.nomQuartier
          this.vol = this.data[index].vol
          this.viol = this.data[index].viol
          this.agression = this.data[index].agression
          this.idAvis = this.data[index].id
          this.eclairage = this.data[index].eclairagePublique
          this.transport = this.data[index].transport
          this.description = this.data[index].description
          this.qualiteRoute = this.data[index].qualiteRoute

          this.d = {
            id : this.idAvis,
            vol : this.vol ,
            viol : this.viol,
            agression : this.agression,
            transport : this.transport,
            eclairagePublique : this.eclairage,
            nomQuartier : this.quartier,
            description : this.description,
            qualiteRoute : this.qualiteRoute
           }
           console.log(this.d)
           this.avis[this.i] = this.d
           this.i++

        }
        console.log(this.avis)
      },
      error=> console.log(error)
    )
  }

  @Input() get selectedColumns(): any[] {
    return this._selectedColumns;
}

set selectedColumns(val: any[]) {
    //restore original order
    this._selectedColumns = this.cols.filter(col => val.includes(col));
}

}
