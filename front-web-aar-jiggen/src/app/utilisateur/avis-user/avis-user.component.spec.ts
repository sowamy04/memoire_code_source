import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AvisUserComponent } from './avis-user.component';

describe('AvisUserComponent', () => {
  let component: AvisUserComponent;
  let fixture: ComponentFixture<AvisUserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AvisUserComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AvisUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
