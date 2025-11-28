# Projekat: Aplikacija za obračun cene koštanja gotovih jela

**Web projekat** rađen u **PHP, CSS, JS** sa bazom podataka **MySQL**.

---

## Opis projekta
Ova web aplikacija omogućava vođenje evidencije i obračun cene koštanja gotovih jela u restoranu.  
Korisnik može unositi jela, definisati njihovu recepturu sa sastojcima, jedinicama mere i cenama, a aplikacija automatski računa cenu porcije i ukupan trošak jela.

---

## Funkcionalnosti
- Unos gotovog jela (naziv, opis, jedinica mere, planirana količina)  
- Definisanje recepture jela (sastojci iz liste artikala, količina, cena, jedinica mere)  
- Obračun cene koštanja jedne porcije i ukupnog troška  
- Pregled i izmena recepture i cena sastojaka  
- Brisanje sastojaka iz recepture  
- Dinamičko dodavanje i uklanjanje redova u tabeli recepture  

---

## Tehnologije
- **PHP** – serverska logika i obrada forme  
- **MySQL** – baza podataka (`restoran`)  
- **HTML / CSS / JavaScript** – frontend i animacije tabele  
- **XAMPP** – lokalni server (Apache + MySQL)  

---

## Uputstvo za pokretanje

### 1. Instalacija XAMPP-a
- Preuzmite i instalirajte [XAMPP](https://www.apachefriends.org/index.html)

### 2. Pokretanje servera
- Otvorite **XAMPP Control Panel** i pokrenite **Apache** i **MySQL**

### 3. Kopiranje projekta
- Kopirajte ceo folder projekta u `C:\xampp\htdocs\`

### 4. Import baze
- Otvorite [phpMyAdmin](http://localhost/phpmyadmin)  
- Kreirajte novu bazu sa imenom `restoran`  
- Izaberite tab **Import**, odaberite fajl `baze/restoran.sql` i kliknite **Go**

### 5. Pristup aplikaciji
- U browser-u otvorite URL: `http://localhost/NazivFolderaProjekta/`

---

## Napomena
- Preporučuje se korišćenje modernog browser-a (Chrome, Edge, Firefox) za najbolji prikaz tabele i animacija.  
- Svi podaci se čuvaju u MySQL bazi `restoran`.

---

## Autor
- **Nikola Marušić**  
- Email: nikolamarusic58@gmail.com
