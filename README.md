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
