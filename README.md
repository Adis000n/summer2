# DO IT NOW! 📚

**DO IT NOW!** to aplikacja webowa do planowania czasu, stworzona specjalnie dla uczniów. Umożliwia organizację wydarzeń szkolnych takich jak sprawdziany, kartkówki, zadania domowe i obowiązki domowe.

## ✨ Funkcjonalności

### 🎯 Główne funkcje
- **Planowanie wydarzeń**: Dodawanie sprawdzianów, kartkówek, zadań i obowiązków domowych
- **System priorytetów**: Oznaczanie ważności wydarzeń (bardzo ważne, średnio ważne, mało ważne)
- **Harmonogram nauki**: Planowanie dat nauki do poszczególnych wydarzeń
- **Śledzenie postępów**: Oznaczanie zadań jako wykonanych/niewykonanych
- **Statystyki**: Przegląd ukończonych zadań z ostatniego tygodnia
- **Responsive design**: Przystosowana do użytku na komputerze i telefonie

### 📅 Widoki kalendarza
1. **Widok 1**: Tradycyjny kalendarz tygodniowy z kafelkami
2. **Widok 2**: Lista wydarzeń pogrupowanych według typów
3. **Widok 3**: Widok obowiązków domowych z harmonogramem na 7 dni

### 👤 Zarządzanie kontem
- Rejestracja i logowanie użytkowników
- Edycja profilu (nazwa użytkownika, email)
- Zmiana hasła z weryfikacją
- Bezpieczne przechowywanie haseł (hash)

## 🛠️ Technologie

### Backend
- **PHP** - logika serwera i obsługa bazy danych
- **MySQL** - baza danych
- **Sessions** - zarządzanie sesjami użytkowników

### Frontend
- **HTML5** - struktura stron
- **CSS3** - stylizacja i animacje
- **JavaScript** - interaktywność
- **Bootstrap 5** - responsywny framework CSS
- **SweetAlert2** - eleganckie powiadomienia

### Bezpieczeństwo
- Hashowanie haseł (`password_hash()`)
- Prepared statements (ochrona przed SQL Injection)
- Walidacja danych wejściowych
- Escape'owanie danych (`mysqli_real_escape_string()`)

## 📁 Struktura projektu

```
summer2/
├── index.php              # Strona główna
├── login.php              # Logowanie
├── register.php           # Rejestracja
├── kalendarz.php          # Widok 1 - kalendarz główny
├── kalendarz2.php         # Widok 2 - lista wydarzeń
├── kalendarz3.php         # Widok 3 - obowiązki domowe
├── dodawanie.php          # Dodawanie nowych wydarzeń
├── myaccount.php          # Ustawienia konta
├── code.php               # Obsługa aktualizacji profilu
├── haslo.php              # Obsługa zmiany hasła
├── logout.php             # Wylogowanie
├── regulamin.html         # Regulamin
├── db.php                 # Konfiguracja bazy danych
├── style.css              # Główne style CSS
├── README.md              # Ten plik
└── img/                   # Grafiki i ikony
    ├── logo.jpg
    ├── cool-background.png
    ├── red.png
    ├── yellow.png
    ├── green.png
    ├── check.png
    ├── cross.png
    └── awatar.png
```

## 🗄️ Struktura bazy danych

### Tabela `user`
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- username (VARCHAR)
- email (VARCHAR)
- password (VARCHAR) -- zahashowane hasło
```

### Tabela `wydarzenia`
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- nazwa (VARCHAR) -- nazwa wydarzenia
- typ (VARCHAR) -- sprawdzian/kartkowka/zadanie/obowiazek
- waznosc (VARCHAR) -- bardzo/srednio/malo
- data (DATE) -- data wydarzenia
- komentarz (TEXT)
- user_id (INT, FOREIGN KEY)
- zrobione (TINYINT) -- 0/1
```

### Tabela `daty_nauki`
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- wydarzenie_id (INT, FOREIGN KEY)
- data_nauki (DATE)
- zrobione (TINYINT) -- 0/1
```

## 🚀 Instalacja

### Wymagania
- **XAMPP** (Apache + MySQL + PHP)
- **PHP 7.4+**
- **MySQL 5.7+**
- Przeglądarka internetowa

### Kroki instalacji

1. **Sklonuj/pobierz projekt**
   ```bash
   git clone [URL_PROJEKTU]
   # lub pobierz i rozpakuj ZIP
   ```

2. **Umieść w katalogu XAMPP**
   ```
   Skopiuj folder do: C:\xampp\htdocs\projekty\summer2\
   ```

3. **Uruchom XAMPP**
   - Włącz Apache
   - Włącz MySQL

4. **Utwórz bazę danych**
   - Otwórz http://localhost/phpmyadmin
   - Utwórz nową bazę danych (np. `summer_planner`)
   - Zaimportuj strukturę tabel lub stwórz ręcznie

5. **Skonfiguruj połączenie z bazą**
   ```php
   // Edytuj plik db.php
   $host = "localhost";
   $username = "root";
   $password = "";
   $database = "summer_planner";
   ```

6. **Uruchom aplikację**
   ```
   Otwórz: http://localhost/projekty/summer2/
   ```

## 📱 Użytkowanie

### Pierwsze kroki
1. **Rejestracja**: Utwórz nowe konto na stronie rejestracji
2. **Logowanie**: Zaloguj się używając swoich danych
3. **Dodawanie wydarzeń**: Kliknij "➕ Dodaj" i wypełnij formularz
4. **Planowanie nauki**: Dla sprawdzianów i zadań dodaj daty nauki
5. **Śledzenie postępów**: Oznaczaj zadania jako wykonane

### Typy wydarzeń
- **Sprawdzian** 📝 - egzamin z możliwością planowania nauki
- **Kartkówka** 📋 - krótki test z planowaniem nauki  
- **Zadanie** 📚 - zadanie domowe z możliwością planowania
- **Obowiązek** 🏠 - obowiązek domowy bez planowania nauki

### Poziomy ważności
- 🔴 **Bardzo ważne** - czerwona ikona
- 🟡 **Średnio ważne** - żółta ikona  
- 🟢 **Mało ważne** - zielona ikona

## 🎨 Personalizacja

### Zmiana tła
Edytuj pliki CSS aby zmienić obrazy tła:
```css
/* style.css */
body {
    background-image: url('img/custom-background.png');
}
```

### Dostosowanie kolorów
Zmodyfikuj zmienne CSS dla głównych kolorów interfejsu.

## 🔧 Rozwój

### Dodawanie nowych funkcji
1. Utwórz nowy plik PHP w głównym katalogu
2. Dodaj odpowiednie wpisy w menu nawigacyjnym
3. Zaktualizuj bazę danych jeśli potrzeba

### Debugowanie
- Włącz wyświetlanie błędów PHP
- Sprawdź logi Apache w XAMPP
- Użyj narzędzi deweloperskich przeglądarki

## 🤝 Współpraca

Projekt jest otwarty na współpracę! Możesz:
- Zgłaszać błędy (issues)
- Proponować nowe funkcje
- Tworzyć pull requesty
- Poprawiać dokumentację

## 📄 Licencja

Ten projekt jest dostępny na licencji open source. Możesz go swobodnie używać, modyfikować i dystrybuować.

## 👨‍💻 Autor

Projekt stworzony jako aplikacja do planowania czasu dla uczniów.

---

**DO IT NOW!** - Zaplanuj swój sukces! 🎯
