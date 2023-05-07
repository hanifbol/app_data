# app_data

## Installation

1. Clone project ke dalam folder hosting
```
git clone https://github.com/hanifbol/app_data.git
```

2. Copy file config database
```
cd app_data
cp config/config.php.example config/config.php
```

3. Buat database di mysql

4. Setting database properties di dalam file ```config.php```

5. Jalankan sql di file ```src/db/db.sql``` untuk membuat tabel dan seeding data

6. Buka http://localhost/app_data, login dengan default username ```admin``` password ```12345```
