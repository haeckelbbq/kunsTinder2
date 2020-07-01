-- kunstinder DCL data control language

GRANT INSERT, SELECT, UPDATE, DELETE ON kunstinder.*
    TO teilnehmer@localhost IDENTIFIED BY 'teilnehmer';

FLUSH PRIVILEGES;