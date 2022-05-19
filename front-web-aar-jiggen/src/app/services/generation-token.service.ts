import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from './../../environments/environment';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class GenerationTokenService {

  url = environment.apiUrl
  constructor(private http:HttpClient) { }

  getToken(credentials:any){
    return  this.http.post(this.url+'login_check', credentials);
  }

  RecuperationToken(){
    return localStorage.getItem('token');
  }

  logout(){
    return localStorage.removeItem('token');
  }
}
