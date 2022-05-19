import { HttpClient } from '@angular/common/http';
import { environment } from './../../../environments/environment';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class RegionService {

  url = environment.apiUrl
  constructor( private http : HttpClient ) { }

  listeRegions(){
    return this.http.get(this.url+'regions')
  }

  ajouterRegion(region : any){
    return this.http.post(this.url+'regions', region)
  }

  afficherRegion(id: any){
    return this.http.get(this.url+'regions/'+id)
  }

  modifierRegion( id : any, region : any){
    return this.http.put(this.url+'regions/'+id, region)
  }

  supprimerRegion(id : any){
    return this.http.delete(this.url+'regions/'+id)
  }
}
