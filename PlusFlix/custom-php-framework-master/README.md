Bezpieczny workflow z GITEM

ZAWSZE w tej kolejności:

Przed pracą:
git pull origin main

Po pracy:
git add .
git commit -m "Opis zmian"
git push origin main

KOMPILOWANIE (mozna to tak nazwać?) STYLI LESS
W katalogu
Projekt\PlusFlix\custom-php-framework-master

lessc public\assets\src\less\style.less public\assets\dist\style.min.css --clean-css --source-map

URUCHOMIENIE STRONY
php -S localhost:56646 -t .\public 