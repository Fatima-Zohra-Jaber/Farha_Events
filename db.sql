
--Create Database : 
	CREATE DATABASE FarhaEvents

-- Create the 'Evenement' table
CREATE TABLE Evenement (
    eventId CHAR(6) PRIMARY KEY,
    eventType VARCHAR(50) NOT Null,
    eventTitle VARCHAR(100) NOT Null, 
    eventDescription TEXT NOT Null,
    TariffNormal DECIMAL(10, 2) NOT Null,
    TariffReduit DECIMAL(10, 2) NOT Null,
    CONSTRAINT checkTypeEvent check (eventType in ('Cinéma','Musique','Théatre','Rencontres'))
);

-- Create the 'Salle' table
CREATE TABLE Salle (
    NumSalle INT PRIMARY KEY,
    capSalle INT NOT Null,
    DescSalle TEXT NOT Null
);	


-- Create the 'Utilisateur' table
CREATE TABLE Utilisateur (
    idUser CHAR(10) PRIMARY KEY,
    nomUser VARCHAR(30) NOT Null,
    prenomUser VARCHAR(30) NOT Null,
    mailUser VARCHAR(100) UNIQUE,
    motPasse char(30) UNIQUE
);	

-- Create the 'Edition' table
CREATE TABLE Edition (
    editionId int AUTO_INCREMENT PRIMARY KEY,
    dateEvent DATE NOT NULL,
    timeEvent TIME NOT NULL,
    eventId CHAR(6) NOT NULL,
    numSalle INT NOT NULL,
    image varchar(200),
    FOREIGN KEY (eventId) REFERENCES Evenement(eventId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (NumSalle) REFERENCES Salle(NumSalle) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create the 'Reservation' table
CREATE TABLE Reservation (
    idReservation INT PRIMARY KEY AUTO_INCREMENT,
    qteBilletsNormal INT NOT Null,
    qteBilletsReduit INT NOT Null,
    editionId int NOT Null,
    idUser CHAR(10) NOT Null,
    FOREIGN KEY (editionId) REFERENCES Edition(editionId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (idUser) REFERENCES Utilisateur(idUser) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create the 'Billet' table
CREATE TABLE Billet (
    billetId VARCHAR(15) PRIMARY KEY,
    typeBillet VARCHAR(50) NOT Null,
    placeNum INT NOT Null,
    idReservation INT NOT Null,
    FOREIGN KEY (idReservation ) REFERENCES Reservation(idReservation) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT CheckTypeBillet CHECK(typeBillet IN('Normal','Reduit'))
);


--Insertion dans la table Evenement
INSERT INTO Evenement (eventId, eventType, eventTitle, eventDescription, TariffNormal, TariffReduit) VALUES
('EV001', 'Musique', 'Festival Gnaoua et Musiques du Monde', 'Festival annuel à Essaouira célébrant la musique Gnaoua et les musiques du monde.', 500.00, 300.00),
('EV002', 'Rencontres', 'Moussem d’Asilah', 'Festival culturel international annuel à Asilah, mettant en avant l\'art et la culture.', 400.00, 250.00),
('EV003', 'Musique', 'Festival Mawazine', 'Festival de musiques et rythmes du monde organisé à Rabat et Salé.', 600.00, 350.00),
('EV004', 'Théatre', 'Festival International des Nomades', 'Festival célébrant la culture nomade à M\'Hamid El Ghizlane.', 300.00, 200.00);

--Insertion dans la table Salle
INSERT INTO Salle (NumSalle, capSalle, DescSalle) VALUES
(1, 1000, 'Grande scène en plein air à Essaouira'),
(2, 800, 'Salle culturelle à Asilah'),
(3, 15000, 'Scène OLM Souissi à Rabat'),
(4, 500, "Espace culturel à M\'Hamid El Ghizlane");

--Insertion dans la table Utilisateur
INSERT INTO Utilisateur (idUser, nomUser, prenomUser, mailUser, motPasse) VALUES
('USR0000001', 'El Amrani', 'Omar', 'omar.elamrani@gmail.com', 'pass1234'),
('USR0000002', 'Benali', 'Sara', 'sara.benali@yahoo.com', 'securepass'),
('USR0000003', 'Khalid', 'Rachid', 'rachid.khalid@outlook.com', 'mypassword'),
('USR0000004', 'Moulay', 'Fatima', 'fatima.moulay@hotmail.com', 'fatimasecret');

--Insertion dans la table Edition
INSERT INTO Edition (dateEvent, timeEvent, eventId, numSalle, image) VALUES
('2025-06-27', '20:00:00', 'EV001', 1, 'gnaoua2025.jpg'),
('2025-07-15', '18:00:00', 'EV002', 2, 'moussem_asilah2025.jpg'),
('2025-05-20', '21:00:00', 'EV003', 3, 'mawazine2025.jpg'),
('2025-03-15', '19:00:00', 'EV004', 4, 'festival_nomades2025.jpg');

--Insertion dans la table Reservation
INSERT INTO Reservation (qteBilletsNormal, qteBilletsReduit, editionId, idUser) VALUES
(2, 1, 1, 'USR0000001'),
(4, 2, 2, 'USR0000002'),
(1, 0, 3, 'USR0000003'),
(3, 2, 4, 'USR0000004');

--Insertion dans la table Billet
INSERT INTO Billet (billetId, typeBillet, placeNum, idReservation) VALUES
('BIL00000001', 'Normal', 1, 1),
('BIL00000002', 'Reduit', 2, 1),
('BIL00000003', 'Normal', 3, 2),
('BIL00000004', 'Reduit', 4, 2),
('BIL00000005', 'Normal', 5, 3),
('BIL00000006', 'Normal', 6, 4),
('BIL00000007', 'Reduit', 7, 4);
