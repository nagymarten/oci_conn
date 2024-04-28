Rendszer telepítése

Hozzunk létre egy ssh-tunnelt, a kabinetes szerverhez. ssh –L 1521:orania2.inf.u-szeged.hu:1521 hXXXXXX@linux.inf.u-szeged.hu
Clone-ozzuk le a git repositoryt. A XAMPP/htdocs mappába. 
Indítsuk el a XAMPP-ot. Engedélyezzök az OCI-extensiont és nyissuk meg a localhost/oci_conn oldalt.

Rendszer használata

Regisztráljunk egy új user-t aki user jogot fog kapni a rendszertől alapméretezetten. Ez a felhasználó képes megtekinteni a header-ben is szereplő listákat, illetve ki tud jelentkezni.
Ha kijelentkeztünk lépjünk be a következő felhasználóval: admin és jelszóval: admin. Egy admin felhasználó a továbbiakban képes CRUD műveleteket végrehajtani, a normál felhasználók számára
liszázott és nem listázott adatsorokon.
A header-ben található egy plusz fül a db-connection állapotának megtekintésére. Ha egy nem admin felhsználó pbálna megtekinteni olyan listákat amik számára nem elérhetőek, a kliens átirányításra kerül egy számára is
megtekinthető fő oldalra.

Munkamegosztás: 

Martin Legyen egy ablak vagy weboldal, amelyen csak annyi látszik, hogy az alkalmazás csatlakozott az adatbázishoz
Kristóf Bejelentkezési űrlap

Martin felhasználónév és jelszó fogadása
Kristóf jelszó titkosítása
Martin bejelentkezési adatok összevetése az adatbázisban szereplőkkel
Kristóf SQL-befecskendezések megakadályozása
Martin visszajelzés a felhasználónak
Martin Regisztrációs űrlap

Martin felhasználói név és/vagy e-mail cím, jelszó bekérése
Martin jelszó bekérése még egyszer
Martin jelszó titkosítása
Kristóf SQL-befecskendezések megakadályozása
Martin felhasználói rekord beszúrása az adatbázisba
Martin visszajelzés a felhasználónak, hogy sikerült-e vagy sem
Martin felhasználói szerepkör hozzárendelése a felhasználóhoz
Kristóf Alapadatokat tartalmazó táblákhoz adatfelvitel, módosítás és törlés megvalósítása űrlapon keresztül

Martin az alapadatokat tartalmazó táblákhoz (amelyek nem kapcsolótáblák, nem tartalmaznak külső kulcsot) el kell készíteni az űrlapokat
Kristóf Ha mindegyik tábla tartalmaz valami miatt külső kulcsot, akkor annak értékét nem kell megadni (NULL érték lehet az adatbázisban)
Martin Felhasználói szerepkör ellenőrzése az űrlap esetében (jó esetben nem is látszik a felhasználó számára, de van olyan felhasználó, aki számára elérhető a funkció)
Martin A felhasználói input ellenőrzése
Kristóf SQL-befecskendezés megakadályozása
Martin Adatrekordok rögzítése 
