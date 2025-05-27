# Kodu ülesanne 

See on lihtne veebileht, mis pole loomulikut teab mis asjalik, funktsionaalne või veel vähem turvaline. Aga see leht töötab, kõik mis on siin olemas. Kloonige projekt enda arvutisse ja vaadake, mis sellel lehel toimub ja kuidas töötab. Kogu "info" on koodis olemas. 

# Ülesanne

1. Loo uus andmebaas
2. Loo uus tabel vastavalt feedback.csv sisule
3. Kasuta andmebaasi ühenduseks [mysqli](https://www.php.net/manual/en/book.mysqli.php) või [PDO](https://www.php.net/manual/en/pdo.connections.php) prepare lahendust. Proovi luua klass, nagu tunnis tegime. Vihjeks Python ja SQLite ühendus.
4. Kontakt lehelt saadetav info tuleb lisada andmebaasi tabelisse mille sa eelpool tegid. Lisaks kirjutab ka csv faili. Olemasolevat csv faili sisu **ei pea** andmebaasi tabelisse lisama.
5. Admin leht **peab näitama** andmebaasist saadavat infot ja sorteeritud peab olema kuupäeva järgi. Kuupäevad veebilehel on vastavalt eesti keelele.
6. Tagasiside kirjeid peab saama ka kustutada! Muutmist **EI OLE** vaja teha, sest see on "kliendi" kommentaar. Ainult admin peab saama seda teha!

## Lisa
- Proovi logimine teha sessiooni põhiseks. Ainult parooliga.

# GitHub
Kuna õpetaja GitHubi osa jääb külge, siis Visual Code'is Terminalis anna käsklus 
```
git remote remove origin
```
sest õpetaja githubi ilma kutseta lisada ei saa, selle asemel peab olmea teie enda oma. Sellega kaob ära teil Source Control juures värviline pilve ikoon aga sinine **main** jääb alles, mis on lokaalne git.

# Tegija tegemised

Siia palun tee loetelu kõikidest asjadest mida sa tegid. Järjekord pole oluline.
* Tegevus
1. Tegin phpMyAdmin-is uue andmebaasi nimega "homework". Lisasin sellele tabeli nimega "feedback". Struktuur: id; added; name; email; message.
2. Tegin faili settings.php andmebaasiga suhtlemiseks
3. Tegin faili mysqli.php kuhu lisasin kõik andmebaasiga seotud funktsioonid.
4. Lisasin faili submit_feedback.php:
    * Faili algusesse peale php tag-i read require_once("settings.php"); require_once("mysqli.php"); // laevad andmebaasiseaded ja ühenduse klassi.
    * If lauses peale csv faili kirjutamise osa lisasin: $db = new Db();
        $db->addFeedback($timestamp, $name, $email, $message); //kasutab DB klasii addFeedback() funktsiooni andmete lisamiseks andmebaasi.
5. Failis admin.php tegin järgnevad muudatuded:
    * Faili algusesse peale php tag-i read require_once("settings.php"); require_once("mysqli.php"); // laevad andmebaasiseaded ja ühenduse klassi.
    * Kommenteerisin välja koodi osa mis laeb andmed CSV failist.
    * Lisasin eelneva asemele read  $db = new Db();
        $rows = $db->getFeedback(); mis kasutab DB klassis olevat funktsiooni getFeedback().
    *Lisasin kustutamise jaoks If lause peale $Db = new Db(). See kasutab mysqli.php-s olevat funktsiooni deleteFeedback().
    *Html osas lisasin ühe tabeli rea nimega "Kustuta". Muudtsin html osas tbody php osa nii, et laeb lahtritesse iga rea eraldi ja viimasesse lahtrisse lisasin kustutamise nuppu. 
6. Kuna feedback.csv failist võiksid ka kustutatud postitused ära kaduda, siis kõige lihtsam tundus teha nii, et peale iga kustutamist kirjutatakse csv fail lihtsalt uuesti     värske andmebaasi sisuga. Ei ole kindel kas on õige lähenemine aga töötab. Selleks lisasin admin.php kustutamise if lause järele csv faili kirjutamise osa. 

# Lisa - Sessiooni põhiseks sisselogimiseks:
    * login.php - Lisasin faili algusesse session_start(); ja setcookie asemele $_SESSION['admin_auth'] = true;
    * admin.php - Lisasin faili algusesse session_start(); ja //if ($_COOKIE["admin_auth"] !== "true") asemele if (empty($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true)
    * logout.php - Lisasin faili algusesse session_start(); ja setcookie os aslemele sessiooni tühjendamiseks ja lõpetamineks lisasin session_start();
session_unset(); session_destroy();



