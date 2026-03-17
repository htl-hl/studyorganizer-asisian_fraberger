# Datenbank Design

## Beziehungen

- `Users` 1:n `Homework`
- `Teachers` 1:n `Subjects`
- `Subjects` 1:n `Homework`

## Tabellen

### Users

- `U_ID` INT, Primary Key, Auto Increment
- `U_username` VARCHAR(255), eindeutig, nicht null
- `U_password` VARCHAR(255), nicht null, gehashed gespeichert
- `U_auth_key` VARCHAR(255), nicht null
- `U_role` VARCHAR(255), nicht null (`admin` oder `user`)

### Teachers

- `T_ID` INT, Primary Key, Auto Increment
- `T_name` VARCHAR(255), nicht null
- `T_is_active` BOOLEAN, nicht null, Default `TRUE`

Hinweis:
Lehrer werden nicht geloescht, sondern nur auf inaktiv gesetzt.

### Subjects

- `S_ID` INT, Primary Key, Auto Increment
- `S_name` VARCHAR(255), eindeutig, nicht null
- `S_T_ID` INT, Foreign Key auf `Teachers.T_ID`

### Homework

- `H_ID` INT, Primary Key, Auto Increment
- `H_title` VARCHAR(255), nicht null
- `H_description` TEXT, optional
- `H_due_date` DATE, nicht null
- `H_is_done` BOOLEAN, nicht null, Default `FALSE`
- `H_S_ID` INT, Foreign Key auf `Subjects.S_ID`
- `H_U_ID` INT, Foreign Key auf `Users.U_ID`

## Fachliche Regeln

- Jeder User sieht nur Homework mit der eigenen `H_U_ID`.
- Homework muss genau einem Fach zugeordnet sein.
- Homework kann als erledigt markiert werden.
- Erledigte Homework ist gesperrt und nicht mehr veraenderbar.
- Admins verwalten Lehrer, Faecher und User.
