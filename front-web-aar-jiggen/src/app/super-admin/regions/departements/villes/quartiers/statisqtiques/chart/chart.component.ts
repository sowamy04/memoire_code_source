import { ActivatedRoute } from '@angular/router';
import { QuartierService } from './../../../../../../services/quartier.service';
import { Component, OnInit } from '@angular/core';
import { Label, PluginServiceGlobalRegistrationAndOptions } from 'ng2-charts';
import { ChartDataSets, ChartOptions, ChartType } from 'chart.js';
//import * as pluginDataLabels from 'chartjs-plugin-datalabels';

@Component({
  selector: 'app-chart',
  templateUrl: './chart.component.html',
  styleUrls: ['./chart.component.scss']
})
export class ChartComponent implements OnInit {

  id : any
  transport : any = 0
  vol : any = 0
  viol : any = 0
  agression : any = 0
  eclairage : any = 0
  i : any
  public barChartOptions : ChartOptions = {
    responsive: true,
    scales : { xAxes:[{}], yAxes:[{
      ticks: {
        beginAtZero: true,
        max: 5
    }
    }] },
    plugins : {
      datalabels : {
        anchor : "end",
        align : "end"
      }
    }
  }
  public barChartLabels : Label[] =[ 'Viol','Vol','Agression', 'Transport', 'Eclairage' ]
  public barChartType : ChartType = "bar"
  public barChartLegend  = true
  public barChartPlugins = []
  public barChartData : ChartDataSets[] = []

  public barChartColors: any [] =[
    {
        backgroundColor:'#f00020',
        //borderColor: "rgba(10,150,132,1)",
       // borderWidth: 5
    },
    {
        backgroundColor:'rgb(97 174 55, 1 )',
       // borderColor: "rgba(10,150,132,1)",
       // borderWidth: 5,
    }
]
  constructor( private quartierService : QuartierService, private route : ActivatedRoute) {}

  ngOnInit(): void {
    this.id = this.route.snapshot.params['id']
    this.getQuartier()
  }

  getQuartier(){
    this.quartierService.afficherquartier(this.id).subscribe(
      (resultat : any) => {
        console.log(resultat)
        this.i = 0
        for (let index = 0; index < resultat.avis.length; index++) {
          this.vol = this.vol + resultat.avis[index].vol
          this.viol = this.viol + resultat.avis[index].viol
          this.agression= this.agression + resultat.avis[index].agression
          this.transport = this.transport + resultat.avis[index].transport
          this.eclairage = this.eclairage + resultat.avis[index].eclairagePublique
          this.i++
        }
        this.vol = this.vol / this.i
        this.viol = this.viol / this.i
        this.agression= this.agression / this.i
        this.transport = this.transport / this.i
        this.eclairage = this.eclairage / this.i
        console.log ('ok')
        console.log(this.vol, this.viol, this.agression, this.transport, this.eclairage)
        console.log ('ok')
        this.barChartData = [
          {data : [ this.vol, this.viol, this.agression, this.transport, this.eclairage] , label:'Caractéristiques'}
        ]
      },
      error => console.log('Erreur lors de la récupération !')
    )
  }

}
