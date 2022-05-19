import { HttpClient } from '@angular/common/http';
import { environment } from './../../../environments/environment';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ItineraireService {

  url = environment.apiUrl
  constructor( private http:HttpClient ) { }

  listeItineraires(){
    return this.http.get(this.url+'itineraires')
  }

  afficherItineraire(id : any){
    this.http.get(this.url+'simple_users/itineraires/'+id)
  }

  modifierItineraire(id : any, itineraires:any){
    this.http.put(this.url+'simple_users/itineraires/'+id, itineraires)
  }

  deleteItineraire(id: any){
    this.http.delete(this.url+'simple_users/itineraires/'+id)
  }
}
