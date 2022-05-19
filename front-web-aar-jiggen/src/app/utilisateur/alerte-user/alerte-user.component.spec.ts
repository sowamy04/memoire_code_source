import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AlerteUserComponent } from './alerte-user.component';

describe('AlerteUserComponent', () => {
  let component: AlerteUserComponent;
  let fixture: ComponentFixture<AlerteUserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AlerteUserComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AlerteUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
