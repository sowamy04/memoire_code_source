import { ComponentFixture, TestBed } from '@angular/core/testing';

import { StatsVillesComponent } from './stats-villes.component';

describe('StatsVillesComponent', () => {
  let component: StatsVillesComponent;
  let fixture: ComponentFixture<StatsVillesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ StatsVillesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(StatsVillesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
