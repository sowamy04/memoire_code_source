import { HttpClient } from '@angular/common/http';
import { environment } from './../../../environments/environment';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class QuartierService {

  url = environment.apiUrl
  constructor( private http:HttpClient ) { }

  listequartiers(){
    return this.http.get(this.url+'quartiers')
  }

  ajouterQuartier(quartier : any){
    return this.http.post(this.url+'villes/quartiers', quartier)
  }

  afficherquartier(id : any){
    return this.http.get(this.url+'villes/quartiers/'+id)
  }

  modifierquartier(id : any, dept:any){
    return this.http.put(this.url+'villes/quartiers/'+id, dept)
  }

  deletequartier(id: any){
    return this.http.delete(this.url+'villes/quartiers/'+id)
  }
}
