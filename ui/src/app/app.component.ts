import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { FormsModule, NgForm } from '@angular/forms';

interface Sector {
  id: number;
  name: string;
}

interface UserDto {
  id?: number;
  name: string;
  agreeTerms: boolean;
  sectors: number[];
}

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
})
export class AppComponent implements OnInit {
  sectors: Sector[] = [];
  user: UserDto = { name: '', agreeTerms: false, sectors: [] };
  saved = false;
  errorMessage = '';

  private apiBase = '/api/users';
  private storageKey = 'currentUserId';

  constructor(private http: HttpClient) {}

  ngOnInit(): void {
    this.http.get<Sector[]>('/api/sectors').subscribe({
      next: (data) => (this.sectors = data),
      error: () => (this.errorMessage = 'Failed to load sectors'),
    });

    const storedId = sessionStorage.getItem(this.storageKey);
    if (storedId) {
      this.http.get<UserDto>(`${this.apiBase}/${storedId}`).subscribe({
        next: (u) => (this.user = u),
        error: () => (this.errorMessage = 'Failed to load user data'),
      });
    }
  }

  onSubmit(form: NgForm) {
    this.errorMessage = '';
    this.saved = false;

    if (form.invalid) {
      this.errorMessage = 'Please complete all fields and agree to terms.';
      return;
    }

    const request$ = this.user.id
      ? this.http.put<UserDto>(`${this.apiBase}/${this.user.id}`, this.user)
      : this.http.post<UserDto>(this.apiBase, this.user);

    request$.subscribe({
      next: (response) => {
        this.saved = true;
        this.user.id = response.id;
        sessionStorage.setItem(this.storageKey, `${response.id}`);
      },
      error: () => {
        this.errorMessage = 'Save failed – please try again.';
      },
    });
  }
}
