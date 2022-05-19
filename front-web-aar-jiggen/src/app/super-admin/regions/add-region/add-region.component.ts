import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { RegionService } from '../../services/region.service';
import { MessageService } from 'primeng/api';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-add-region',
  templateUrl: './add-region.component.html',
  styleUrls: ['./add-region.component.scss'],
  providers: [MessageService]
})
export class AddRegionComponent implements OnInit {

  regionForm : FormGroup | any

  constructor( private location : Location, private regionService : RegionService, private messageService : MessageService ) { }

  ngOnInit(): void {
    this.regionForm = new FormGroup({
      nomRegion : new FormControl('', Validators.required)
    });
  }

  ajouterRegion(){
    console.log(this.regionForm.value)
    this.regionService.ajouterRegion(this.regionForm.value).subscribe(
      (resultat : any) => {
        console.log (resultat)
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Région ajoutée avec succès',
          showConfirmButton: false,
          timer: 1500
        })
      },
      (error : any) => console.log ('Erreur lors de l\'insertion ! ')
    )
  }

  retour(){
    this.location.back()
  }

}
