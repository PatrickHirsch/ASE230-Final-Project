# ASE230-Final-Project

MyPhotoVault is an interactive photo and image hosting and sharing platform developed by [Luke Norberg](https://github.com/lukenorberg), [Patrick Hirsch](https://github.com/PatrickHirsch), & [Sarah Riley](https://github.com/Saraphoo) for [Dr. Nicholas Caporusso](https://github.com/NicholasCaporusso)'s Fall 2023 ASE 230, Server-Side Programming, course at Northern Kentucky University.

The web app is developed in PHP with a mySQL environment to maintain a database.  The database connection is configured within the `/db/db.php` file, the environment can be setup with the `/db/setupDB.sql` script.  A sample dataset is provided within the `/doc` directory including a prepopulated database and image set.

Users within the MyPhotoVault can upload their photos and image files to be viewed on their own profile or the public feed on the homepage.  Authenticated users can leave comments or ratings on any other user's photos.  Any user may create galleries to feature a collection of photos, either their own or other user's.  These galleris may be either publicly listed on their profile, or private and only visible to the owning user.

Admin users are denoted by a status of `3` in the `users` table.  These users have the ability to delete any image or comment as well as blocking a user so that all their images and comments are hidden from visitors

[Final Project Presentation](https://youtu.be/bc6cFMs4VFA)
