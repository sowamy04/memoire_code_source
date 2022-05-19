import { HttpClient } from '@angular/common/http';
import { environment } from './../../../environments/environment';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class MeritoireService {

  url = environment.apiUrl
  constructor( private http:HttpClient ) { }

  listePersonne_confiances(){
    return this.http.get(this.url+'personne_confiances')
  }

  afficherPersonneConfiance(id : any){
    this.http.get(this.url+'simple_users/personne_confiances/'+id)
  }

  modifierPersonneConfiance(id : any, personne_confiances:any){
    this.http.put(this.url+'simple_users/personne_confiances/'+id, personne_confiances)
  }

  deletepersonneConfiance(id: any){
    this.http.delete(this.url+'simple_users/personne_confiances/'+id)
  }
}
