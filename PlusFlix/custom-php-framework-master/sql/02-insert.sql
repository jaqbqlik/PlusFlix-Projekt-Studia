-- ============================================
-- 02-insert-productions.sql
-- Dane testowe: 30 produkcji filmowych
-- ============================================

-- UWAGA: Platformy już istnieją w bazie, więc pomijamy ich wstawianie
-- INSERT INTO platform (name, logo_url) VALUES ... -- POMINIĘTE

-- Wstawienie 30 produkcji (tylko jeśli jeszcze nie istnieją)
INSERT OR IGNORE INTO production (title, type, description, release_year, genre, poster_path) VALUES
-- Seriale
('Stranger Things', 'serial', 'When a young boy vanishes, a small town uncovers a mystery involving secret experiments, terrifying supernatural forces and one strange little girl.', 2016, 'Sci-Fi, Horror, Drama', '/images/dziwnerzeczy.png'),
('The Last of Us', 'serial', 'Twenty years after a fungal outbreak ravages the planet, survivors Joel and Ellie embark on a brutal journey across post-pandemic America.', 2023, 'Drama, Sci-Fi, Thriller', '/images/ostatnieznas.jpg'),
('The Mandalorian', 'serial', 'The travels of a lone bounty hunter in the outer reaches of the galaxy, far from the authority of the New Republic.', 2019, 'Sci-Fi, Action, Adventure', '/images/mandek.png'),
('Wednesday', 'serial', 'Wednesday Addams attempts to master her emerging psychic ability while investigating murders that terrorized the local town.', 2022, 'Comedy, Horror, Mystery', '/images/czwartek.jpg'),
('Breaking Bad', 'serial', 'A chemistry teacher diagnosed with cancer turns to manufacturing meth to secure his family''s future.', 2008, 'Crime, Drama, Thriller', '/images/placeholder-user.jpg'),
('The Witcher', 'serial', 'Geralt of Rivia, a solitary monster hunter, struggles to find his place in a world where people often prove more wicked than beasts.', 2019, 'Fantasy, Action, Adventure', '/images/placeholder-user.jpg'),
('The Crown', 'serial', 'Follows the political rivalries and romance of Queen Elizabeth II''s reign and the events that shaped the second half of the 20th century.', 2016, 'Drama, History', '/images/placeholder-user.jpg'),
('Game of Thrones', 'serial', 'Nine noble families fight for control over the lands of Westeros, while an ancient enemy returns after being dormant for millennia.', 2011, 'Fantasy, Drama, Adventure', '/images/placeholder-user.jpg'),
('The Office', 'serial', 'A mockumentary on a group of typical office workers, where the workday consists of ego clashes, inappropriate behavior, and tedium.', 2005, 'Comedy', '/images/placeholder-user.jpg'),
('Black Mirror', 'serial', 'An anthology series exploring a twisted, high-tech multiverse where humanity''s greatest innovations and darkest instincts collide.', 2011, 'Sci-Fi, Thriller, Drama', '/images/placeholder-user.jpg'),
('The Boys', 'serial', 'A group of vigilantes set out to take down corrupt superheroes who abuse their superpowers.', 2019, 'Action, Comedy, Crime', '/images/placeholder-user.jpg'),
('Succession', 'serial', 'The Roy family is known for controlling the biggest media and entertainment company in the world. However, their world changes when their father steps down from the company.', 2018, 'Drama', '/images/placeholder-user.jpg'),
('Dark', 'serial', 'A family saga with a supernatural twist, set in a German town, where the disappearance of two young children exposes the relationships among four families.', 2017, 'Crime, Drama, Mystery', '/images/placeholder-user.jpg'),
('The Bear', 'serial', 'A young chef from the fine dining world returns to Chicago to run his family''s sandwich shop.', 2022, 'Comedy, Drama', '/images/placeholder-user.jpg'),
('Peaky Blinders', 'serial', 'A gangster family epic set in 1900s England, centering on a gang who sew razor blades in the peaks of their caps.', 2013, 'Crime, Drama', '/images/placeholder-user.jpg'),
-- Filmy
('Dune', 'film', 'Paul Atreides arrives on Arrakis, the most dangerous planet in the universe, to secure the future of his family and people.', 2021, 'Sci-Fi, Adventure', '/images/diunka.png'),
('Oppenheimer', 'film', 'The story of American scientist J. Robert Oppenheimer and his role in the development of the atomic bomb.', 2023, 'Biography, Drama, History', '/images/posters/oppenheimer-poster.png'),
('Inception', 'film', 'A thief who steals corporate secrets through dream-sharing technology is given the inverse task of planting an idea.', 2010, 'Sci-Fi, Action, Thriller', '/images/placeholder-user.jpg'),
('The Dark Knight', 'film', 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests.', 2008, 'Action, Crime, Drama', '/images/placeholder-user.jpg'),
('Pulp Fiction', 'film', 'The lives of two mob hitmen, a boxer, a gangster and his wife intertwine in four tales of violence and redemption.', 1994, 'Crime, Drama', '/images/placeholder-user.jpg'),
('The Shawshank Redemption', 'film', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 1994, 'Drama', '/images/placeholder-user.jpg'),
('Interstellar', 'film', 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity''s survival.', 2014, 'Adventure, Drama, Sci-Fi', '/images/placeholder-user.jpg'),
('The Matrix', 'film', 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.', 1999, 'Action, Sci-Fi', '/images/placeholder-user.jpg'),
('Avatar', 'film', 'A paraplegic Marine dispatched to the moon Pandora on a unique mission becomes torn between following his orders and protecting the world he feels is his home.', 2009, 'Action, Adventure, Fantasy', '/images/placeholder-user.jpg'),
('Parasite', 'film', 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.', 2019, 'Drama, Thriller', '/images/placeholder-user.jpg'),
('Joker', 'film', 'In Gotham City, mentally troubled comedian Arthur Fleck is disregarded and mistreated by society. He then embarks on a downward spiral of revolution and bloody crime.', 2019, 'Crime, Drama, Thriller', '/images/placeholder-user.jpg'),
('Avengers: Endgame', 'film', 'After the devastating events of Avengers: Infinity War, the universe is in ruins. With the help of remaining allies, the Avengers assemble once more.', 2019, 'Action, Adventure, Drama', '/images/placeholder-user.jpg'),
('Spider-Man: Into the Spider-Verse', 'film', 'Teen Miles Morales becomes the Spider-Man of his universe, and must join with five spider-powered individuals from other dimensions.', 2018, 'Animation, Action, Adventure', '/images/placeholder-user.jpg'),
('Everything Everywhere All at Once', 'film', 'An aging Chinese immigrant is swept up in an insane adventure, where she alone can save the world by exploring other universes.', 2022, 'Action, Adventure, Comedy', '/images/placeholder-user.jpg'),
('Top Gun: Maverick', 'film', 'After thirty years, Maverick is still pushing the envelope as a top naval aviator, training a detachment of graduates for a specialized mission.', 2022, 'Action, Drama', '/images/placeholder-user.jpg');

-- Przypisanie produkcji do platform (INSERT OR IGNORE dla bezpieczeństwa)
INSERT OR IGNORE INTO production_availability (production_id, platform_id, is_available) VALUES
-- Stranger Things (1) -> Netflix
(1, 1, 1),
-- The Last of Us (2) -> HBO Max
(2, 2, 1),
-- The Mandalorian (3) -> Disney+
(3, 3, 1),
-- Wednesday (4) -> Netflix
(4, 1, 1),
-- Breaking Bad (5) -> Netflix
(5, 1, 1),
-- The Witcher (6) -> Netflix
(6, 1, 1),
-- The Crown (7) -> Netflix
(7, 1, 1),
-- Game of Thrones (8) -> HBO Max
(8, 2, 1),
-- The Office (9) -> Prime Video
(9, 4, 1),
-- Black Mirror (10) -> Netflix
(10, 1, 1),
-- The Boys (11) -> Prime Video
(11, 4, 1),
-- Succession (12) -> HBO Max
(12, 2, 1),
-- Dark (13) -> Netflix
(13, 1, 1),
-- The Bear (14) -> Disney+
(14, 3, 1),
-- Peaky Blinders (15) -> Netflix
(15, 1, 1),
-- Dune (16) -> HBO Max, Prime Video
(16, 2, 1),
(16, 4, 1),
-- Oppenheimer (17) -> Prime Video
(17, 4, 1),
-- Inception (18) -> HBO Max, Prime Video
(18, 2, 1),
(18, 4, 1),
-- The Dark Knight (19) -> HBO Max
(19, 2, 1),
-- Pulp Fiction (20) -> Prime Video
(20, 4, 1),
-- The Shawshank Redemption (21) -> HBO Max
(21, 2, 1),
-- Interstellar (22) -> Prime Video
(22, 4, 1),
-- The Matrix (23) -> HBO Max
(23, 2, 1),
-- Avatar (24) -> Disney+
(24, 3, 1),
-- Parasite (25) -> HBO Max
(25, 2, 1),
-- Joker (26) -> HBO Max
(26, 2, 1),
-- Avengers: Endgame (27) -> Disney+
(27, 3, 1),
-- Spider-Man: Into the Spider-Verse (28) -> Netflix
(28, 1, 1),
-- Everything Everywhere All at Once (29) -> Prime Video
(29, 4, 1),
-- Top Gun: Maverick (30) -> Prime Video, Apple TV+
(30, 4, 1),
(30, 5, 1);