import { ComponentFixture, TestBed } from '@angular/core/testing';

import { StatisqtiquesComponent } from './statisqtiques.component';

describe('StatisqtiquesComponent', () => {
  let component: StatisqtiquesComponent;
  let fixture: ComponentFixture<StatisqtiquesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ StatisqtiquesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(StatisqtiquesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
