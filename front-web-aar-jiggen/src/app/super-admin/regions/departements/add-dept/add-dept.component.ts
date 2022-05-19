import { DeptService } from './../../../services/dept.service';
import { RegionService } from './../../../services/region.service';
import { Location } from '@angular/common';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import {map, startWith} from 'rxjs/operators';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-add-dept',
  templateUrl: './add-dept.component.html',
  styleUrls: ['./add-dept.component.scss']
})
export class AddDeptComponent implements OnInit {

  deptForm : FormGroup | any
  data : any
  region = new FormControl();
  regions : any[] = []
  //filteredOptions: Observable<string[]> | any;
  filteredOptions : any;
  tab : any[] = []
  i : any
  constructor( private location : Location, private regionService : RegionService, private deptService : DeptService) {

  }

  ngOnInit(): void {
    this.getRegion()
    this.filteredOptions = this.region.valueChanges
      .pipe(
        startWith(''),
        map(value => typeof value === 'string' ? value : value.nomRegion),
        map(name => name ? this._filter(name) : this.regions.slice())
      );
      this.deptForm = new FormGroup({
        nomDept : new FormControl('', Validators.required),
        region : new FormControl('', Validators.required)
      });
  }

  ajouterDept(){
    console.log(this.deptForm.value)
    const regionId = this.deptForm.value.region.id
    this.data = {
      'nomDept' : this.deptForm.value.nomDept,
      'regions': regionId
    }
    //console.log(this.data)
    this.deptService.ajouterDept(this.data).subscribe(
      (resultat : any) => {
        console.log(resultat)
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Département ajouté avec succès!',
          showConfirmButton: false,
          timer: 1500
        })
      },
      error => console.log ('Erreur lors de l\'insertion', error)
     )
  }

  getRegion(){
    this.regionService.listeRegions().subscribe(
      (resultat : any)=> {
        console.log(resultat)
        this.i = 0
        for (let index = 0; index < resultat.length; index++) {
          if (resultat[index].statut == true) {
            this.tab[this.i] = resultat[index]
            this.i++
          }
        }
        this.regions = this.tab
        this.filteredOptions = this.tab
      },
      error => {
        console.log ( 'Erreur lors du chargement', error )
      }
    )
  }

  displayFn(region: any): string {
    return region && region.nomRegion ? region.nomRegion : '';
  }

  private _filter(name: string): any[] {
    const filterValue = name.toLowerCase();

    return this.regions.filter(option => option.nomRegion.toLowerCase().indexOf(filterValue) === 0);
  }

  retour(){
    this.location.back()
  }

}
