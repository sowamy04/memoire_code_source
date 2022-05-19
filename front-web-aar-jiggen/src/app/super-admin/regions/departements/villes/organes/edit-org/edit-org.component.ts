import { ActivatedRoute } from '@angular/router';
import { OrganesService } from './../../../../../services/organes.service';
import { VilleService } from './../../../../../services/ville.service';
import { startWith, map } from 'rxjs/operators';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { Observable } from 'rxjs';
import Swal from 'sweetalert2';


@Component({
  selector: 'app-edit-org',
  templateUrl: './edit-org.component.html',
  styleUrls: ['./edit-org.component.scss']
})
export class EditOrgComponent implements OnInit {

  orgForm : FormGroup | any
  ville = new FormControl();
  i : any
  tab : any[] = []
  villes: any[] = [];
  filteredOptions: any;
  id : any
  orgVal : any
  villeVal : any
  emailVal : any
  telVal : any
  data : any
  constructor( private location : Location, private villeService : VilleService, private orgService : OrganesService,
                private route : ActivatedRoute
    ) {}

  ngOnInit(): void {
    this.id = this.route.snapshot.params['id']
    this.getOrgane()
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

  getOrgane(){
    this.orgService.afficherOrgane(this.id).subscribe(
      (resultat : any) => {
        console.log(resultat)
        this.orgVal = resultat.nomOrgane
        this.emailVal = resultat.email
        this.telVal = resultat.telephone
        this.villeVal = resultat.ville
      },
      error => console.log('Erreur lors de la récupération !', error)
    )
  }

  modifierOrgane(){
    console.log(this.orgForm.value)
    this.data = {
      'nomOrgane' : this.orgForm.value.nomOrgane,
      'telephone': this.orgForm.value.telephone,
      'email' : this.orgForm.value.email,
      'villes' : this.orgForm.value.ville.id
    }
    Swal.fire({
      title: 'Voulez-vous vraiment modifier ces informations?',
      showDenyButton: true,
      confirmButtonText: `modifier`,
      denyButtonText: `annuler`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        this.orgService.modifierOrgane(this.id, this.data).subscribe(
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

