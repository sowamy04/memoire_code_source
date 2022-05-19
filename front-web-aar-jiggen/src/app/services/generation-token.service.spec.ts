import { TestBed } from '@angular/core/testing';

import { GenerationTokenService } from './generation-token.service';

describe('GenerationTokenService', () => {
  let service: GenerationTokenService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(GenerationTokenService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
