import { ComponentFixture, TestBed } from '@angular/core/testing';

import { OrganesComponent } from './organes.component';

describe('OrganesComponent', () => {
  let component: OrganesComponent;
  let fixture: ComponentFixture<OrganesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ OrganesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(OrganesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
