import { HttpClient } from '@angular/common/http';
import { environment } from './../../../environments/environment';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AlerteService {

  url = environment.apiUrl
  constructor( private http:HttpClient ) { }

  listealertes(){
    return this.http.get(this.url+'alertes')
  }

  afficherAlerte(id : any){
    this.http.get(this.url+'simple_users/alertes/'+id)
  }

  modifierAlerte(id : any, alerte:any){
    this.http.put(this.url+'simple_users/alertes/'+id, alerte)
  }

  deleteAlerte(id: any){
    this.http.delete(this.url+'simple_users/alertes/'+id)
  }
}
