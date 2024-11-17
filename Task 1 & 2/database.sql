CREATE DATABASE IF NOT EXISTS sportradar_backend;
USE sportradar_backend;

-- Table: Team
CREATE TABLE IF NOT EXISTS Team (
    Team_ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL,
    Official_Name VARCHAR(100),
    Slug VARCHAR(100),
    Abbreviation VARCHAR(10),
    Team_Country_Code CHAR(3),
    Stage_Position VARCHAR(50)
);

-- Table: Result
CREATE TABLE IF NOT EXISTS Result (
    Result_ID INT PRIMARY KEY AUTO_INCREMENT,
    Home_Goals INT,
    Away_Goals INT,
    Winner VARCHAR(100),
    Message TEXT
);

-- Table: Stage
CREATE TABLE IF NOT EXISTS Stage (
    Stage_ID VARCHAR(50) PRIMARY KEY,
    Name VARCHAR(50) NOT NULL,
    Ordering INT
);

-- Table: Match
CREATE TABLE IF NOT EXISTS `Match` (
    Match_ID INT PRIMARY KEY AUTO_INCREMENT,
    Season INT NOT NULL,
    Status VARCHAR(50) NOT NULL,
    Time_Venue_UTC TIME NOT NULL,
    Date_Venue DATE NOT NULL,
    Stadium VARCHAR(100),
    Home_Team_ID_foreignkey INT,
    Away_Team_ID_foreignkey INT,
    Result_ID_foreignkey INT,
    Stage_ID_foreignkey VARCHAR(50),
    Origin_Competition_ID VARCHAR(50),
    Origin_Competition_Name VARCHAR(100),
    Sport VARCHAR(50) NOT NULL,
    FOREIGN KEY (Home_Team_ID_foreignkey) REFERENCES Team(Team_ID),
    FOREIGN KEY (Away_Team_ID_foreignkey) REFERENCES Team(Team_ID),
    FOREIGN KEY (Result_ID_foreignkey) REFERENCES Result(Result_ID),
    FOREIGN KEY (Stage_ID_foreignkey) REFERENCES Stage(Stage_ID)
);
