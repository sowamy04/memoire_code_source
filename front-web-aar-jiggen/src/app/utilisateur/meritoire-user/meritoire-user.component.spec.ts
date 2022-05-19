import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MeritoireUserComponent } from './meritoire-user.component';

describe('MeritoireUserComponent', () => {
  let component: MeritoireUserComponent;
  let fixture: ComponentFixture<MeritoireUserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MeritoireUserComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MeritoireUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
