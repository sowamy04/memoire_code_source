import { QuartierService } from './../../../../../services/quartier.service';
import { VilleService } from './../../../../../services/ville.service';
import { startWith, map } from 'rxjs/operators';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { Observable } from 'rxjs';
import Swal from 'sweetalert2';


@Component({
  selector: 'app-add-quartier',
  templateUrl: './add-quartier.component.html',
  styleUrls: ['./add-quartier.component.scss']
})
export class AddQuartierComponent implements OnInit {

  quartierForm : FormGroup | any
  ville = new FormControl();
  i : any
  tab : any[] = []
  villes: any[] = [];
  filteredOptions: any;
  data : any
  constructor( private location : Location, private villeService : VilleService, private quartierService : QuartierService) {}

  ngOnInit(): void {
    this.getVilles()
    this.filteredOptions = this.ville.valueChanges
      .pipe(
        startWith(''),
        map(value => typeof value === 'string' ? value : value.nomVille),
        map(name => name ? this._filter(name) : this.villes.slice())
      );
      this.quartierForm = new FormGroup({
        nomQuartier : new FormControl('', Validators.required),
        ville : new FormControl('', Validators.required)
      });
  }

  getVilles(){
    this.villeService.listeVilles().subscribe(
      (resultat : any) => {
        console.log(resultat)
        this.i = 0
        for (let index = 0; index < resultat.length; index++) {
          if (resultat[index].statut == true) {
            this.tab[this.i] = resultat[index]
            this.i++
          }
        }
        this.villes = this.tab
        this.filteredOptions = this.tab
      }
    )
  }

  ajouterQuartier(){
    console.log(this.quartierForm.value)
    this.data = {
      'nomQuartier' : this.quartierForm.value.nomQuartier,
      'villes' : this.quartierForm.value.ville.id
    }
    this.quartierService.ajouterQuartier(this.data).subscribe(
      (resultat : any) =>{
        console.log(resultat)
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Quartier ajouté avec succès!',
          showConfirmButton: false,
          timer: 1500
        })
      },
      error => console.log('Erreur lors de l\'insertion!', error)
    )
  }

  displayFn(ville: any): string {
    return ville && ville.nomVille ? ville.nomVille : '';
  }

  private _filter(name: string): any[] {
    const filterValue = name.toLowerCase();

    return this.villes.filter(option => option.nomVille.toLowerCase().indexOf(filterValue) === 0);
  }

  retour(){
    this.location.back()
  }

}
