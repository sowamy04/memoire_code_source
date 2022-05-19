import { VilleService } from '../../../../services/ville.service';
import Swal from 'sweetalert2';
import { DeptService } from 'src/app/super-admin/services/dept.service';
import { startWith, map } from 'rxjs/operators';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-add-ville',
  templateUrl: './add-ville.component.html',
  styleUrls: ['./add-ville.component.scss']
})
export class AddVilleComponent implements OnInit {

  villeForm : FormGroup | any
  dept = new FormControl();
  i : any
  tab : any[] = []
  depts: any[] = []
  data : any
  filteredOptions: any;

  constructor( private location : Location, private deptService : DeptService, private villeService : VilleService) {

  }

  ngOnInit(): void {
    this.getDepts()
    this.filteredOptions = this.dept.valueChanges
      .pipe(
        startWith(''),
        map(value => typeof value === 'string' ? value : value.nomDept),
        map(name => name ? this._filter(name) : this.depts.slice())
      );
      this.villeForm = new FormGroup({
        nomVille : new FormControl('', Validators.required),
        dept : new FormControl('', Validators.required)
      });
  }

  ajouterVille(){
    console.log(this.villeForm.value)
    this.data = {
      'nomVille' : this.villeForm.value.nomVille,
      'depts' : this.villeForm.value.dept.id
    }
    this.villeService.ajouterVille(this.data).subscribe(
      (resultat : any) => {
        console.log (resultat)
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Ville ajoutée avec succès!',
          showConfirmButton: false,
          timer: 1500
        })
      }
    )
  }

  getDepts(){
    this.deptService.listeDept().subscribe(
      (resultat : any) => {
        console.log( resultat)
        this.i = 0
        for (let index = 0; index < resultat.length; index++) {
          if (resultat[index].statut == true) {
            this.tab[this.i] = resultat[index]
            this.i++
          }
        }
        this.depts = this.tab
        this.filteredOptions = this.tab
      },
      error => console.log('Erreur lors de la récupération')
    )
  }

  displayFn(dept: any): string {
    return dept && dept.nomDept ? dept.nomDept : '';
  }

  private _filter(name: string): any[] {
    const filterValue = name.toLowerCase();

    return this.depts.filter(option => option.nomDept.toLowerCase().indexOf(filterValue) === 0);
  }

  retour(){
    this.location.back()
  }

}
