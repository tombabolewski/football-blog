# Football Blog

## Etapy powstawania projektu

1. Analiza tekstualna treści zadania i wyodrębnienie z niej aktorów, zdarzeń, komend, etc.
1. Zrozumienie logiki biznesowej, user stories
1. Priorytetyzacja zadań
1. Utworzenie nowego projektu laravel przez `composer`
1. Wstępna konfiguracja projektu i środowiska
1. Dodanie dodatkowych zalezności przez `composer`
1. Dodanie funkcjonalności autentykacji - rejestracja, logowanie, reset hasła
1. Dodanie ról i uprawnień przypisanych do nich
1. Dodanie migracji, modelu `Post` i funkcjonalności oraz innych klas z nim związanych
1. Dodanie migracji, modelu `Image` i funkcjonalności oraz innych klas z nim związanych
1. Rozpoczęcie pokrycia kodu testami i poprawki w trakcie testowania

## Z jakimi częściami miałeś /miałaś problem i dlaczego?

1. Problem z czasem i/lub ambicjami - zaproponowany deadline jest zbyt krótki jak na załozenia, jakie przed sobą postawiłem
1. Problem ze środowiskiem programistycznym - wygasła mi licencja na PhpStorm, do którego jestem przyzwyczajony i musiałem szybko przesiąśc się na VSCodium

## Które części uważasz że można by lepiej dopracować gdybyś miał/a więcej czasu?

1. Zwiększyłbym pokrycie kodu testami funkcjonalnymi i jednostkowymi. Krótki termin sprawił, ze postanowiłem odłozyc je na koniec zamiast wybrac TDD. Niestety, przez to skazany byłem na testowanie manualne pisanych przeze mnie funkcjonalności i nie zawsze wiedziałem co się w moim kodzie dzieje.
1. Dodałbym dokumentację API, najchętniej z uzyciem biblioteki Scribe i samodokumentującego się kodu
1. Zrobiłbym audyt i optymalizację zapytań, dodał indeksy
1. Pozbyłbym się nadmiarowej wstępnej konfiguracji laravela
1. Zrobiłbym cache w sposób świadomy
1. Rozwinąłbym obsługę błędów i ujednolicenie zwrotek
1. Dopracowałbym role i uprawnienia
1. Dodałbym event logi i dodał integrację z serwisem typu Sentry/Bugsnag
