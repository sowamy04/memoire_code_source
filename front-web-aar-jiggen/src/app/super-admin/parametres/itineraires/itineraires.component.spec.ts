import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ItinerairesComponent } from './itineraires.component';

describe('ItinerairesComponent', () => {
  let component: ItinerairesComponent;
  let fixture: ComponentFixture<ItinerairesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ItinerairesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(ItinerairesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
