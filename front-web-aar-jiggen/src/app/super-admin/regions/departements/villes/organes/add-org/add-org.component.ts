import { OrganesService } from './../../../../../services/organes.service';
import { startWith, map } from 'rxjs/operators';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { Observable } from 'rxjs';
import { VilleService } from 'src/app/super-admin/services/ville.service';
import Swal from 'sweetalert2';


@Component({
  selector: 'app-add-org',
  templateUrl: './add-org.component.html',
  styleUrls: ['./add-org.component.scss']
})
export class AddOrgComponent implements OnInit {

  orgForm : FormGroup | any
  ville = new FormControl();
  villes: any[] = []
  i : any
  tab : any[] = []
  filteredOptions: any;
  data : any
  constructor( private location : Location, private villeService : VilleService, private orgService : OrganesService) {

  }

  ngOnInit(): void {
    this.getVilles()
    this.filteredOptions = this.ville.valueChanges
      .pipe(
        startWith(''),
        map(value => typeof value === 'string' ? value : value.nomVille),
        map(name => name ? this._filter(name) : this.villes.slice())
      );
      this.orgForm = new FormGroup({
        nomOrgane : new FormControl('', Validators.required),
        ville : new FormControl('', Validators.required),
        telephone : new FormControl('', Validators.required),
        email : new FormControl('', Validators.required)
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

  ajouterOrgane(){
    console.log(this.orgForm.value)
    this.data = {
      'nomOrgane' : this.orgForm.value.nomOrgane,
      'telephone' : this.orgForm.value.telephone,
      'email' : this.orgForm.value.email,
      'villes' : this.orgForm.value.ville.id
    }
    this.orgService.ajouterOrgane(this.data).subscribe(
      (resultat : any) => {
        console.log(resultat)
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'L\'organe est ajoutée avec succès!',
          showConfirmButton: false,
          timer: 1500
        })
      },
      error => console.log('Erreur lors de l\'insertion !', error)
    )
  }

  displayFn(dept: any): string {
    return dept && dept.nomVille ? dept.nomVille : '';
  }

  private _filter(name: string): any[] {
    const filterValue = name.toLowerCase();

    return this.villes.filter(option => option.nomVille.toLowerCase().indexOf(filterValue) === 0);
  }

  retour(){
    this.location.back()
  }

}
