import { TestBed } from '@angular/core/testing';

import { MeritoireService } from './meritoire.service';

describe('MeritoireService', () => {
  let service: MeritoireService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MeritoireService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
