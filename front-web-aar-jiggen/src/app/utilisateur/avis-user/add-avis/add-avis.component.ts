import { AvisService } from './../../../super-admin/services/avis.service';
import { QuartierService } from './../../../super-admin/services/quartier.service';
import { startWith, map } from 'rxjs/operators';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { Observable } from 'rxjs';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-add-avis',
  templateUrl: './add-avis.component.html',
  styleUrls: ['./add-avis.component.scss']
})
export class AddAvisComponent implements OnInit {

  avisForm : FormGroup | any
  quartier = new FormControl();

  filteredOptions: any;
  i : any
  tab :any[] = []
  quartiers : any[] = []
  dataAvis : any
  constructor( private location : Location, private quartierService : QuartierService, private avisService : AvisService) {

  }

  ngOnInit(): void {
    this.getQuartiers()
    this.filteredOptions = this.quartier.valueChanges
      .pipe(
        startWith(''),
        map(value => typeof value === 'string' ? value : value.nomQuartier),
        map(name => name ? this._filter(name) : this.quartiers.slice())
      );
      this.avisForm = new FormGroup({
        vol : new FormControl('', Validators.required),
        quartier : new FormControl('', Validators.required),
        viol : new FormControl('', Validators.required),
        agression : new FormControl('', Validators.required),
        transport : new FormControl('', Validators.required),
        qualite : new FormControl('', Validators.required),
        eclairage : new FormControl('', Validators.required),
        description : new FormControl('', Validators.required)
      });
  }

  getQuartiers(){
    this.quartierService.listequartiers().subscribe(
      (resultat : any) => {
        console.log (resultat)
        this.i = 0
        for (let index = 0; index < resultat.length; index++) {
          if (resultat[index].statut == true) {
            this.tab[this.i] = resultat[index]
            this.i++
          }
        }
        this.quartiers = this.tab
        this.filteredOptions = this.tab
      },
      error => console.log ('Erreur lors du chargement', error)
    )
  }

  displayFn(dept: any): string {
    return dept && dept.nomQuartier ? dept.nomQuartier : '';
  }

  private _filter(name: string): any[] {
    const filterValue = name.toLowerCase();

    return this.quartiers.filter(option => option.nomQuartier.toLowerCase().indexOf(filterValue) === 0);
  }

  ajouterAvis(){
    console.log(this.avisForm.value)
    this.dataAvis = {
      'quartiers' : this.avisForm.value.quartier.id,
      'vol' : +this.avisForm.value.vol,
      'viol': +this.avisForm.value.viol,
      'agression' : +this.avisForm.value.agression,
      'transport' : +this.avisForm.value.transport,
      'eclairagePublique' : +this.avisForm.value.eclairage,
      'qualiteRoute' : this.avisForm.value.qualite,
      'description' : this.avisForm.value.description
    }
    //console.log(this.data)
    this.avisService.ajouterAvis(this.dataAvis).subscribe(
      (resultat : any) => {
        console.log(resultat)
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Avis enregistré avec succès!',
          showConfirmButton: false,
          timer: 1500
        })
      },
      error => console.log ('Erreur lors de l\'insertion', error)
     )
  }

  retour(){
    this.location.back()
  }

}
