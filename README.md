# Aplikacja do zarządzania szkolnymi projektami

## System do Zarządzania Projektami Szkolnymi i Uczelnianymi

Przedstawiamy koncepcję systemu do zarządzania projektami w środowisku edukacyjnym, zaprojektowanego z myślą o usprawnieniu współpracy pomiędzy administratorami, opiekunami i studentami. Platforma ma na celu ułatwienie realizacji projektów, monitorowanie postępów oraz promowanie metodyk zwinnych, takich jak Scrum.

### Kluczowe Role Użytkowników
System przewiduje trzy distinctywne role, każda z dedykowanym zestawem uprawnień i funkcjonalności, co zapewnia porządek i bezpieczeństwo danych.

- **Administrator**: Odpowiada za techniczną i organizacyjną stronę platformy. Do jego głównych zadań należy zarządzanie kontami użytkowników (opiekunów i studentów), konfiguracja globalnych ustawień systemu oraz dbanie o jego sprawne działanie. Administrator ma wgląd we wszystkie projekty, ale nie ingeruje w ich merytoryczną zawartość.

- **Opiekun (Nauczyciel/Wykładowca)**: Mózgiem operacji projektowych jest opiekun. Ta rola umożliwia tworzenie nowych projektów od podstaw lub klonowanie już istniejących, co pozwala na ponowne wykorzystanie sprawdzonych schematów. Opiekun definiuje strukturę projektu, w tym etapy i zadania, a także zarządza dostępem studentów do poszczególnych projektów. Kluczową funkcją jest możliwość śledzenia postępów prac studentów w czasie rzeczywistym, udzielanie informacji zwrotnych oraz ocena wykonanych zadań.

- **Uczeń/Student**: Główny wykonawca projektów. Student może samodzielnie wybierać projekty z puli udostępnionej przez opiekunów lub zostać przypisany do konkretnego zadania. Interfejsem roboczym studenta jest tablica Scrum, która w intuicyjny sposób wizualizuje przepływ pracy.

### Struktura Projektu
Każdy projekt w systemie ma jasno zdefiniowaną, hierarchiczną strukturę, która ułatwia planowanie i realizację.

- **Projekt**: Nadrzędna jednostka organizacyjna, posiadająca tytuł, opis, opiekuna prowadzącego oraz listę przypisanych studentów.

- **Etapy**: Projekt podzielony jest na logiczne etapy (np. "Analiza", "Implementacja", "Testowanie"), z których każdy ma określony czas na realizację. Taka segmentacja pozwala na lepsze zarządzanie harmonogramem i monitorowanie kluczowych kamieni milowych.

- **Zadania**: W ramach każdego etapu zdefiniowane są konkretne zadania do wykonania. Każdemu zadaniu przypisany jest procentowy udział w czasie całego etapu, co pomaga studentom w ocenie pracochłonności i priorytetyzacji obowiązków.

### Realizacja Projektu i Tablica Scrum
Centralnym punktem dla studenta jest interaktywna tablica Scrum, która wizualizuje proces pracy nad projektem i promuje zwinne podejście do zarządzania zadaniami. Tablica składa się z trzech podstawowych kolumn:

- **Do wykonania (To Do)**: Tutaj znajdują się wszystkie zadania zdefiniowane przez opiekuna, które czekają na rozpoczęcie.

- **W trakcie (In Progress)**: Zadania, nad którymi student aktualnie pracuje. Przeniesienie zadania do tej kolumny sygnalizuje opiekunowi rozpoczęcie prac.

- **Wykonane (Done)**: Ukończone zadania trafiają do tej kolumny, co stanowi podstawę do oceny przez opiekuna i jest sygnałem do zamknięcia danego zadania.

Student, przeciągając zadania (w formie "karteczek") pomiędzy kolumnami, w prosty i przejrzysty sposób zarządza swoimi obowiązkami i informuje o postępach. Taki mechanizm pozwala na bieżąco śledzić "wąskie gardła" i efektywnie planować dalsze działania.

### Przykładowy Przepływ Pracy

worzenie Projektu: Opiekun tworzy nowy projekt, definiuje jego etapy (np. Etap 1: Badania - 2 tygodnie, Etap 2: Prototypowanie - 3 tygodnie) oraz zadania w każdym etapie (np. w Etapie 1: "Przegląd literatury" - 40% czasu etapu, "Przygotowanie ankiety" - 60% czasu etapu).

1. **Przypisanie Studenta**: Opiekun przypisuje studenta do stworzonego projektu.

2. **Realizacja**: Student loguje się do systemu i na swojej tablicy Scrum widzi zadania w kolumnie "Do wykonania". Przeciąga zadanie "Przegląd literatury" do kolumny "W trakcie".

3. **Monitoring**: Opiekun w panelu zarządzania projektem widzi w czasie rzeczywistym, że student rozpoczął pracę nad konkretnym zadaniem.

4. **Ukończenie Zadania**: Po zakończeniu pracy nad przeglądem literatury, student przeciąga zadanie do kolumny "Wykonane".

5. **Ocena i Feedback**: Opiekun otrzymuje powiadomienie o ukończeniu zadania i może je zweryfikować, a następnie przekazać studentowi swoje uwagi lub je zatwierdzić.

System ten, dzięki swojej elastyczności i intuicyjności, ma potencjał, by stać się nieocenionym narzędziem wspierającym proces dydaktyczny i przygotowującym studentów do pracy w nowoczesnych, zwinnych zespołach projektowych.