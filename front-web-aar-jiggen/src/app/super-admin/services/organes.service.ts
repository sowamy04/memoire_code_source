import { HttpClient } from '@angular/common/http';
import { environment } from './../../../environments/environment';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class OrganesService {

  url = environment.apiUrl
  constructor( private http:HttpClient ) { }

  listeOrganes(){
    return this.http.get(this.url+'organes')
  }

  ajouterOrgane(organe : any){
    return this.http.post(this.url+'villes/organes', organe)
  }

  afficherOrgane(id : any){
    return this.http.get(this.url+'villes/organes/'+id)
  }

  modifierOrgane(id : any, org:any){
    return this.http.put(this.url+'villes/organes/'+id, org)
  }

  deleteOrgane(id: any){
    return this.http.delete(this.url+'villes/organes/'+id)
  }
}
