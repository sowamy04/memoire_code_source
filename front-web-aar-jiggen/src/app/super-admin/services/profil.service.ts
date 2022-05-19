import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { environment } from './../../../environments/environment';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ProfilService {

  url = environment.apiUrl
  constructor( private http : HttpClient ) { }

  listerProfils() : Observable<any>{
    return this.http.get<any>(this.url+'super_admin/profils')
  }

  deleteProfil(id: number){
    return this.http.delete(this.url+'super_admin/profils/'+id);
  }

  getProfil(id : any){
    return this.http.get(this.url+'super_admin/profils/'+id);
  }

}
