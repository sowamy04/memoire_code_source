import { TestBed } from '@angular/core/testing';

import { OrganesService } from './organes.service';

describe('OrganesService', () => {
  let service: OrganesService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(OrganesService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
