import { QuartierService } from './../../super-admin/services/quartier.service';
import { StatService } from './../../super-admin/services/stat.service';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-stats-villes',
  templateUrl: './stats-villes.component.html',
  styleUrls: ['./stats-villes.component.scss']
})
export class StatsVillesComponent implements OnInit {

  statistiques : any[] = []
  data : any[] = []
  d = {}
  y : any
  eclairage : any = 0
  vol : any = 0
  viol : any = 0
  agression : any = 0
  transport : any = 0
  quartier : any
  id : any
  niveau : any
  x : any
  constructor( private statService : StatService, private quartierService : QuartierService ) { }

  ngOnInit(): void {
    this.showstats()
  }

  showstats(){
    this.statService.listeStats().subscribe(
      (resultat : any) => {
        console.log(resultat)
        this.statistiques = resultat
        this.quartierService.listequartiers().subscribe(
          (res : any) => {
            console.log (res)
            this.y = 0
            this.x = 0
            for (let i = 0; i < res.length; i++) {
              for (let index = 0; index < resultat.length; index++) {
                if(resultat[index].quartier.id == res[i].id){
                  this.eclairage = this.eclairage + resultat[index].eclairagePublique
                  this.vol = this.vol + resultat[index].vol
                  this.viol = this.viol + resultat[index].viol
                  this.agression = this.agression + resultat[index].agression
                  this.transport = this.transport + resultat[index].transport
                  this.id =  resultat[index].quartier.id
                  this.quartier = resultat[index].quartier.nomQuartier
                  this.x ++
                  console.log(this.transport, this.agression, this.viol, this.vol, this.eclairage)
                }
              }
              if(this.vol != 0 && this.transport != 0 && this.viol != 0 && this.agression != 0 && this.eclairage != 0){
                this.niveau=(this.vol * 15 + this.agression * 20 + this.vol * 15 + this.viol * 40 + this.transport * 10 ) / (this.x * 100)
                this.d = {
                  id : this.id,
                  vol : this.vol / this.x,
                  viol : this.viol / this.x,
                  agression : this.agression / this.x,
                  transport : this.transport / this.x,
                  eclairagePublique : this.eclairage / this.x,
                  nomQuartier : this.quartier,
                  niveau : this.niveau
                 }
                 console.log(this.d)
                 this.data[this.y] = this.d
                 this.y++
                 this.agression = 0
                 this.viol = 0
                 this.vol = 0
                 this.eclairage = 0
                 this.transport = 0
                 this.x = 0
              }
            }
            console.log(this.data)
            this.statistiques = this.data
          },
          error => console.log('Erreur lors de la récupération de la liste des quartiers')
        )

      },
      error => console.log('Erreur lors de la récupération', error)
    )
  }

}

