import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MeritoiresComponent } from './meritoires.component';

describe('MeritoiresComponent', () => {
  let component: MeritoiresComponent;
  let fixture: ComponentFixture<MeritoiresComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MeritoiresComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MeritoiresComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
