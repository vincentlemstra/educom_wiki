--  authors:
INSERT INTO `author` (`id`, `firstname`, `preposition`, `lastname`, `email`, `date_birth`, `password`, `description`) VALUES 
  (NULL, 'Vincent', NULL, 'Lemstra', 'vincent@mail.com', '2001-01-01', 'password', NULL), 
  (NULL, 'Koen', 'van', 'Rijswijk', 'koen@mail.com', '2002-02-02', 'password', NULL),
  (NULL, 'Yoeri', NULL, 'Lastname', 'Yoeri@mail.com', '2003-03-03', 'password', NULL)

-- articles:
INSERT INTO `article` (`id`, `author_id`, `title`, `img`, `explanation`, `code_block`, `date_edit`, `date_create`) VALUES 
  (NULL, '1', 'PHP for loop', NULL, 'The for loop - Loops through a block of code a specified number of times.', 'for (init counter; test counter; increment counter) {\r\n code to be executed for each iteration;\r\n}\r\n\r\nParameters:\r\n\r\ninit counter: Initialize the loop counter value\r\ntest counter: Evaluated for each loop iteration. If it evaluates to TRUE, the loop continues. If it evaluates to FALSE, the loop ends.\r\nincrement counter: Increases the loop counter value', current_timestamp(), current_timestamp()),
  (NULL, '2', 'PHP while loop', NULL, 'The while loop - Loops through a block of code as long as the specified condition is true.', 'while (condition is true) {code to be executed;}', current_timestamp(), current_timestamp())

-- tags:
INSERT INTO `tag` (`id`, `title`) VALUES 
  (NULL, 'PHP'), 
  (NULL, 'For Loop'), 
  (NULL, 'While loop')

-- article_tags
INSERT INTO `article_tag` (`article_id`, `tag_id`) VALUES 
  ('2', '1'), 
  ('2', '2'),
  ('3', '1'), 
  ('3', '3')