import { ActivatedRoute } from '@angular/router';
import { QuartierService } from './../../../../../services/quartier.service';
import { VilleService } from './../../../../../services/ville.service';
import { startWith, map } from 'rxjs/operators';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { Observable } from 'rxjs';
import Swal from 'sweetalert2';


@Component({
  selector: 'app-edit-quartier',
  templateUrl: './edit-quartier.component.html',
  styleUrls: ['./edit-quartier.component.scss']
})
export class EditQuartierComponent implements OnInit {

  quartierForm : FormGroup | any
  ville = new FormControl();
  villes: any[] = [];
  i : any
  id : any
  tab : any[]= []
  data : any
  filteredOptions: any;
  quartierVal : any
  villeVal :any
  constructor( private location : Location, private villeService : VilleService, private quartierService : QuartierService,
                private route : ActivatedRoute
    ) {}

  ngOnInit(): void {
    this.id = this.route.snapshot.params['id']
    this.getVilles()
    this.getQuartier()
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

  getQuartier(){
    this.quartierService.afficherquartier(this.id).subscribe(
      (resultat : any) => {
        console.log (resultat)
        this.quartierVal = resultat.nomQuartier
        this.villeVal = resultat.villes
      }
    )
  }

  modifierQuartier(){
    console.log(this.quartierForm.value)
    this.data = {
      'nomQuartier' : this.quartierForm.value.nomQuartier,
      'villes': this.quartierForm.value.ville.id,
    }
    Swal.fire({
      title: 'Voulez-vous vraiment modifier ces informations?',
      showDenyButton: true,
      confirmButtonText: `modifier`,
      denyButtonText: `annuler`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        this.quartierService.modifierquartier(this.id, this.data).subscribe(
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
