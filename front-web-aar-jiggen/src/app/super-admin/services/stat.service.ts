import { HttpClient } from '@angular/common/http';
import { environment } from './../../../environments/environment';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class StatService {

  url = environment.apiUrl
  constructor( private http : HttpClient ) { }

  listeStats(){
    return this.http.get(this.url+'simple_users/avis')
  }

}
