use bmgt406_02_db;

create table users (
email varchar(70) primary key, 
firstname varchar (20),
lastname varchar(50), 
password varchar(25)
);

create table workoutFriends (
email1 varchar(70), 
email2 varchar(70), 
foreign key (email1) references users(email),
foreign key (email2) references users(email),  
primary key (email1, email2)
);

create table activities (
AID int Not Null AUTO_INCREMENT, 
actName varchar(30), 
actDate date,
actTime time, 
actDescription varchar(240),
primary key (AID)
);

create table actSignUps (
signUpID int AUTO_INCREMENT,
AID int,
email varchar(20),  
foreign key (AID) references activities(AID),
foreign key (email) references users(email),
primary key (signUpID)
);

insert into users values ("rose@notreal.com","Rose", "Smith", "blarose");
insert into users values ("jCole@dreamville.com","J", "Cole", "coleWorld");
insert into users values ("gordon@ram.com","Gordon", "Ram", "12345");
insert into users values ("paul@jim.com","Paul", "Jim", "kevDev");
insert into users values ( "mf@gmail.com","Maron", "Fasil", "02");
insert into users values ("jYu@gmail.com","Jasmine", "Yu", "Yu12");

insert into workoutFriends values ("rose@notreal.com", "jYu@gmail.com");
insert into workoutFriends values ("jYu@gmail.com", "rose@notreal.com");
insert into workoutFriends values ("jCole@dreamville.com", "mf@gmail.com");
insert into workoutFriends values ("mf@gmail.com", "jCole@dreamville.com");
insert into workoutFriends values ("mf@gmail.com", "jYu@gmail.com");
insert into workoutFriends values ("jYu@gmail.com", "mf@gmail.com");
insert into workoutFriends values ("gordon@ram.com", "jYu@gmail.com");
insert into workoutFriends values ("jYu@gmail.com", "gordon@ram.com");
insert into workoutFriends values ("rose@notreal.com", "gordon@ram.com");
insert into workoutFriends values ("gordon@ram.com", "rose@notreal.com");
insert into workoutFriends values ("rose@notreal.com", "jCole@dreamville.com");
insert into workoutFriends values ("jCole@dreamville.com", "rose@notreal.com");

insert into activities(actName, actDate, actTime, actDescription) 
values ("Swimming", "2016-12-05", "16:00", "Please bring appropriate swimwear.");
insert into activities(actName, actDate, actTime, actDescription) 
values ("Basketball", "2016-12-17", "13:30", "Tournament Style, teams of three");
insert into activities(actName, actDate, actTime, actDescription) 
values ("Biking", "2016-11-20", "7:00", "Mountain bikes recommended.");
insert into activities(actName, actDate, actTime, actDescription) 
values ("Yoga", "2016-12-11", "10:00", "Relax your mind, body and spirit.");
insert into activities(actName, actDate, actTime, actDescription) 
values ("Fishing", "2016-12-5", "14:30", "");

insert into actSignUps(AID, email) values ("1", "jYu@gmail.com");
insert into actSignUps(AID, email) values ("1", "jCole@dreamville.com");
insert into actSignUps(AID, email) values ("1", "mf@gmail.com");
insert into actSignUps(AID, email) values ("2", "rose@notreal.com");
insert into actSignUps(AID, email) values ("3", "gordon@ram.com");
insert into actSignUps(AID, email) values ("3", "rose@notreal.com");
insert into actSignUps(AID, email) values ("4", "jYu@gmail.com");

