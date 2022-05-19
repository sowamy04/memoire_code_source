import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ItineraireUserComponent } from './itineraire-user.component';

describe('ItineraireUserComponent', () => {
  let component: ItineraireUserComponent;
  let fixture: ComponentFixture<ItineraireUserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ItineraireUserComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ItineraireUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
