import { HttpClient } from '@angular/common/http';
import { environment } from './../../../environments/environment';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class VilleService {

  url = environment.apiUrl
  constructor( private http:HttpClient ) { }

  listeVilles(){
    return this.http.get(this.url+'villes')
  }

  afficherVille(id : any){
    return this.http.get(this.url+'departements/villes/'+id)
  }

  modifierVille(id : any, dept:any){
    return this.http.put(this.url+'departements/villes/'+id, dept)
  }

  deleteVille(id: any){
    return this.http.delete(this.url+'departements/villes/'+id)
  }

  ajouterVille (ville : any) {
    return this.http.post(this.url+'departements/villes', ville)
  }
}
