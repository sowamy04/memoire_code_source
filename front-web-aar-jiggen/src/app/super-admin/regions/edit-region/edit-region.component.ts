import { Location } from '@angular/common';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Component, OnInit } from '@angular/core';
import { RegionService } from '../../services/region.service';
import { ActivatedRoute } from '@angular/router';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-edit-region',
  templateUrl: './edit-region.component.html',
  styleUrls: ['./edit-region.component.scss']
})
export class EditRegionComponent implements OnInit {

  regionForm : FormGroup | any
  id : any
  data : any
  constructor( private location : Location, private regionService : RegionService, private route: ActivatedRoute) { }

  ngOnInit(): void {
    this.id = this.route.snapshot.params['id']
    this.getRegion()
    this.regionForm = new FormGroup({
      nomRegion : new FormControl('', Validators.required)
    });
  }

  getRegion(){
    this.regionService.afficherRegion(this.id).subscribe(
      (response : any)=>{
        console.log(response)
        this.data = response
      },
      (error : any)=> console.log(error)
    )
  }

  updateRegion(){
    console.log(this.regionForm.value)
    this.regionService.modifierRegion(this.id , this.regionForm.value).subscribe(
      (resultat : any) => {
        console.log (resultat)
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Région modifié avec succès',
          showConfirmButton: false,
          timer: 1500
        })
        this.location.back()
      },
      error => console.log ('Erreur lors de la modification')
    )
  }

  retour(){
    this.location.back()
  }

}
