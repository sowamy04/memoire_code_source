import { ActivatedRoute } from '@angular/router';
import { DeptService } from './../../../../services/dept.service';
import { VilleService } from './../../../../services/ville.service';
import { startWith, map } from 'rxjs/operators';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { Observable } from 'rxjs';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-edit-ville',
  templateUrl: './edit-ville.component.html',
  styleUrls: ['./edit-ville.component.scss']
})
export class EditVilleComponent implements OnInit {

  villeForm : FormGroup | any
  dept = new FormControl();
  depts: any[] =[]
  filteredOptions: any;
  i : any
  tab : any[] = []
  id : any
  deptVal : any
  villeVal : any
  data : any
  constructor( private location : Location, private deptService : DeptService, private villeService : VilleService,
                private route : ActivatedRoute
    ) {}

  ngOnInit(): void {
    this.id = this.route.snapshot.params['id']
    console.log(this.id)
    this.getVille()
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

  getVille(){
    this.villeService.afficherVille(this.id).subscribe(
      (resultat : any) => {
        console.log (resultat)
        this.villeVal = resultat.nomVille
        this.deptVal = resultat.departement
      }
    )
  }

  updateVille(){
    console.log(this.villeForm.value)
    this.data = {
      'nomVille' : this.villeForm.value.nomVille,
      'depts': this.villeForm.value.dept.id
    }
    Swal.fire({
      title: 'Voulez-vous vraiment modifier les informations de cette ville?',
      showDenyButton: true,
      confirmButtonText: `modifier`,
      denyButtonText: `annuler`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        this.villeService.modifierVille(this.id, this.data).subscribe(
          (resultat : any) => {
            console.log(resultat)
            Swal.fire('Informations de la ville modifiées avec succès!', '', 'success')
          },
          error => console.log('Erreur lors de la modification!', error)
        )
      } else if (result.isDenied) {
        Swal.fire('Modification annulée avec succès!', '', 'info')
      }
    })
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

