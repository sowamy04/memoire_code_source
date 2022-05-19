import { RegionsComponent } from './../../regions.component';
import { ActivatedRoute } from '@angular/router';
import { RegionService } from './../../../services/region.service';
import { startWith, map } from 'rxjs/operators';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit, Input } from '@angular/core';
import { Location } from '@angular/common';
import { Observable } from 'rxjs';
import { DeptService } from 'src/app/super-admin/services/dept.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-edit-dept',
  templateUrl: './edit-dept.component.html',
  styleUrls: ['./edit-dept.component.scss']
})
export class EditDeptComponent implements OnInit {

  deptForm : FormGroup | any
  region = new FormControl();
  id : any
  i : any
  tab : any[] = []
  regions: any[] = [];
  //filteredOptions: Observable<string[]> | any;
  filteredOptions : any
  data : any
  nomDep : any
  nomReg : any
  regionValue : any
  deptValue : any
  constructor( private location : Location, private regionService : RegionService, private route : ActivatedRoute,
                private deptService : DeptService) {

  }

  ngOnInit(): void {
    this.id = this.route.snapshot.params['id']
    this.getRegion()
    this.getDept()
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

  updateDept(){
    console.log(this.deptForm.value)
    this.regionValue = this.deptForm.value.region.id
    this.data = {
      'nomDept' : this.deptForm.value.nomDept,
      'regions': this.regionValue
    }
    Swal.fire({
      title: 'Voulez-vous vraiment modifier ces informations?',
      showDenyButton: true,
      confirmButtonText: `modifier`,
      denyButtonText: `annuler`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        this.deptService.modifierDept(this.id, this.data).subscribe(
          (resultat : any) => {
            console.log(resultat)
            Swal.fire('Informations modifiées avec succès!', '', 'success')
          },
          error => console.log('Erreur lors de la modification!', error)
        )
      } else if (result.isDenied) {
        Swal.fire('Modification annulée avec succès!', '', 'info')
      }
    })

  }

  getDept(){
    this.deptService.afficherDept(this.id).subscribe(
      (resultat : any)=> {
        //console.log(resultat)
        this.data = resultat
        this.nomDep = this.data.nomDept
        //console.log(this.nomDep)
        this.nomReg = this.data.region
      },
      error => console.log('Erreur lors de la récupération des données!')
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
