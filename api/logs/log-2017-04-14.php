<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

INFO - 2017-04-14 11:12:36 --> Config Class Initialized
INFO - 2017-04-14 11:12:36 --> Hooks Class Initialized
DEBUG - 2017-04-14 11:12:36 --> UTF-8 Support Enabled
INFO - 2017-04-14 11:12:36 --> Utf8 Class Initialized
INFO - 2017-04-14 11:12:36 --> URI Class Initialized
INFO - 2017-04-14 11:12:36 --> Router Class Initialized
INFO - 2017-04-14 11:12:36 --> Output Class Initialized
INFO - 2017-04-14 11:12:36 --> Security Class Initialized
DEBUG - 2017-04-14 11:12:36 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-04-14 11:12:36 --> Input Class Initialized
INFO - 2017-04-14 11:12:36 --> Language Class Initialized
INFO - 2017-04-14 11:12:36 --> Loader Class Initialized
INFO - 2017-04-14 11:12:36 --> Controller Class Initialized
INFO - 2017-04-14 11:12:36 --> Model Class Initialized
INFO - 2017-04-14 11:12:36 --> Database Driver Class Initialized
INFO - 2017-04-14 11:12:36 --> Model Class Initialized
INFO - 2017-04-14 11:12:36 --> Helper loaded: form_helper
INFO - 2017-04-14 11:12:36 --> Form Validation Class Initialized
INFO - 2017-04-14 11:12:36 --> Language file loaded: language/chinese/form_validation_lang.php
ERROR - 2017-04-14 11:12:37 --> Query error: Column 'topic_id' in field list is ambiguous - Invalid query: SELECT `topic_answer_id`, `topic_id`, `topic_content`, `topic_answer`.`user_id`, `username`, `photo` as `avatar`, `content` as `answer_content`, `topic_answer`.`update_at`, `follower_count`, `comment_count`, `thumbup_count`
FROM `topic_answer`
JOIN `topic` ON `topic`.`topic_id` = `topic_answer`.`topic_id`
JOIN `user` ON `topic_answer`.`user_id` = `user`.`user_id`
WHERE `topic_answer`.`del` =0
ORDER BY `topic_answer_id` DESC
 LIMIT 2
INFO - 2017-04-14 11:12:37 --> Language file loaded: language/chinese/db_lang.php
INFO - 2017-04-14 11:13:05 --> Config Class Initialized
INFO - 2017-04-14 11:13:05 --> Hooks Class Initialized
DEBUG - 2017-04-14 11:13:05 --> UTF-8 Support Enabled
INFO - 2017-04-14 11:13:05 --> Utf8 Class Initialized
INFO - 2017-04-14 11:13:05 --> URI Class Initialized
INFO - 2017-04-14 11:13:05 --> Router Class Initialized
INFO - 2017-04-14 11:13:05 --> Output Class Initialized
INFO - 2017-04-14 11:13:06 --> Security Class Initialized
DEBUG - 2017-04-14 11:13:06 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-04-14 11:13:06 --> Input Class Initialized
INFO - 2017-04-14 11:13:06 --> Language Class Initialized
INFO - 2017-04-14 11:13:06 --> Loader Class Initialized
INFO - 2017-04-14 11:13:06 --> Controller Class Initialized
INFO - 2017-04-14 11:13:06 --> Model Class Initialized
INFO - 2017-04-14 11:13:06 --> Database Driver Class Initialized
INFO - 2017-04-14 11:13:06 --> Model Class Initialized
INFO - 2017-04-14 11:13:06 --> Helper loaded: form_helper
INFO - 2017-04-14 11:13:06 --> Form Validation Class Initialized
INFO - 2017-04-14 11:13:06 --> Language file loaded: language/chinese/form_validation_lang.php
ERROR - 2017-04-14 11:13:06 --> Query error: Column 'topic_id' in field list is ambiguous - Invalid query: SELECT `topic_answer_id`, `topic_id`, `topic_content`, `topic_answer`.`user_id`, `username`, `photo` as `avatar`, `content` as `answer_content`, `topic_answer`.`update_at`, `follower_count`, `comment_count`, `thumbup_count`
FROM `topic_answer`
JOIN `topic` ON `topic`.`topic_id` = `topic_answer`.`topic_id`
JOIN `user` ON `topic_answer`.`user_id` = `user`.`user_id`
WHERE `topic_answer`.`del` =0
ORDER BY `topic_answer_id` DESC
 LIMIT 2
INFO - 2017-04-14 11:13:06 --> Language file loaded: language/chinese/db_lang.php
INFO - 2017-04-14 11:14:45 --> Config Class Initialized
INFO - 2017-04-14 11:14:45 --> Hooks Class Initialized
DEBUG - 2017-04-14 11:14:45 --> UTF-8 Support Enabled
INFO - 2017-04-14 11:14:45 --> Utf8 Class Initialized
INFO - 2017-04-14 11:14:45 --> URI Class Initialized
INFO - 2017-04-14 11:14:45 --> Router Class Initialized
INFO - 2017-04-14 11:14:45 --> Output Class Initialized
INFO - 2017-04-14 11:14:45 --> Security Class Initialized
DEBUG - 2017-04-14 11:14:45 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-04-14 11:14:45 --> Input Class Initialized
INFO - 2017-04-14 11:14:45 --> Language Class Initialized
INFO - 2017-04-14 11:14:45 --> Loader Class Initialized
INFO - 2017-04-14 11:14:45 --> Controller Class Initialized
INFO - 2017-04-14 11:14:45 --> Model Class Initialized
INFO - 2017-04-14 11:14:45 --> Database Driver Class Initialized
INFO - 2017-04-14 11:14:47 --> Model Class Initialized
INFO - 2017-04-14 11:14:47 --> Helper loaded: form_helper
INFO - 2017-04-14 11:14:47 --> Form Validation Class Initialized
INFO - 2017-04-14 11:14:47 --> Language file loaded: language/chinese/form_validation_lang.php
ERROR - 2017-04-14 11:14:47 --> Query error: Column 'follower_count' in field list is ambiguous - Invalid query: SELECT `topic_answer_id`, `topic_answer`.`topic_id`, `topic_content`, `topic_answer`.`user_id`, `username`, `photo` as `avatar`, `content` as `answer_content`, `topic_answer`.`update_at`, `follower_count`, `comment_count`, `thumbup_count`
FROM `topic_answer`
JOIN `topic` ON `topic`.`topic_id` = `topic_answer`.`topic_id`
JOIN `user` ON `topic_answer`.`user_id` = `user`.`user_id`
WHERE `topic_answer`.`del` =0
ORDER BY `topic_answer_id` DESC
 LIMIT 2
INFO - 2017-04-14 11:14:47 --> Language file loaded: language/chinese/db_lang.php
INFO - 2017-04-14 11:15:26 --> Config Class Initialized
INFO - 2017-04-14 11:15:26 --> Hooks Class Initialized
DEBUG - 2017-04-14 11:15:26 --> UTF-8 Support Enabled
INFO - 2017-04-14 11:15:26 --> Utf8 Class Initialized
INFO - 2017-04-14 11:15:26 --> URI Class Initialized
INFO - 2017-04-14 11:15:26 --> Router Class Initialized
INFO - 2017-04-14 11:15:26 --> Output Class Initialized
INFO - 2017-04-14 11:15:26 --> Security Class Initialized
DEBUG - 2017-04-14 11:15:26 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-04-14 11:15:26 --> Input Class Initialized
INFO - 2017-04-14 11:15:26 --> Language Class Initialized
INFO - 2017-04-14 11:15:26 --> Loader Class Initialized
INFO - 2017-04-14 11:15:26 --> Controller Class Initialized
INFO - 2017-04-14 11:15:26 --> Model Class Initialized
INFO - 2017-04-14 11:15:26 --> Database Driver Class Initialized
INFO - 2017-04-14 11:15:27 --> Model Class Initialized
INFO - 2017-04-14 11:15:27 --> Helper loaded: form_helper
INFO - 2017-04-14 11:15:27 --> Form Validation Class Initialized
INFO - 2017-04-14 11:15:27 --> Language file loaded: language/chinese/form_validation_lang.php
ERROR - 2017-04-14 11:15:27 --> Query error: Column 'follower_count' in field list is ambiguous - Invalid query: SELECT `topic_answer_id`, `topic_answer`.`topic_id`, `topic_content`, `topic_answer`.`user_id`, `username`, `photo` as `avatar`, `content` as `answer_content`, `topic_answer`.`update_at`, `follower_count`, `comment_count`, `thumbup_count`
FROM `topic_answer`
JOIN `topic` ON `topic`.`topic_id` = `topic_answer`.`topic_id`
JOIN `user` ON `topic_answer`.`user_id` = `user`.`user_id`
WHERE `topic_answer`.`del` =0
ORDER BY `topic_answer_id` DESC
 LIMIT 2
INFO - 2017-04-14 11:15:27 --> Language file loaded: language/chinese/db_lang.php
INFO - 2017-04-14 11:17:41 --> Config Class Initialized
INFO - 2017-04-14 11:17:41 --> Hooks Class Initialized
DEBUG - 2017-04-14 11:17:41 --> UTF-8 Support Enabled
INFO - 2017-04-14 11:17:41 --> Utf8 Class Initialized
INFO - 2017-04-14 11:17:41 --> URI Class Initialized
INFO - 2017-04-14 11:17:41 --> Router Class Initialized
INFO - 2017-04-14 11:17:41 --> Output Class Initialized
INFO - 2017-04-14 11:17:41 --> Security Class Initialized
DEBUG - 2017-04-14 11:17:41 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-04-14 11:17:41 --> Input Class Initialized
INFO - 2017-04-14 11:17:41 --> Language Class Initialized
INFO - 2017-04-14 11:17:41 --> Loader Class Initialized
INFO - 2017-04-14 11:17:41 --> Controller Class Initialized
INFO - 2017-04-14 11:17:41 --> Model Class Initialized
INFO - 2017-04-14 11:17:41 --> Database Driver Class Initialized
INFO - 2017-04-14 11:17:42 --> Model Class Initialized
INFO - 2017-04-14 11:17:42 --> Helper loaded: form_helper
INFO - 2017-04-14 11:17:42 --> Form Validation Class Initialized
INFO - 2017-04-14 11:17:42 --> Language file loaded: language/chinese/form_validation_lang.php
INFO - 2017-04-14 11:17:42 --> Final output sent to browser
DEBUG - 2017-04-14 11:17:42 --> Total execution time: 1.6056
INFO - 2017-04-14 11:18:00 --> Config Class Initialized
INFO - 2017-04-14 11:18:00 --> Hooks Class Initialized
DEBUG - 2017-04-14 11:18:00 --> UTF-8 Support Enabled
INFO - 2017-04-14 11:18:00 --> Utf8 Class Initialized
INFO - 2017-04-14 11:18:00 --> URI Class Initialized
INFO - 2017-04-14 11:18:00 --> Router Class Initialized
INFO - 2017-04-14 11:18:00 --> Output Class Initialized
INFO - 2017-04-14 11:18:00 --> Security Class Initialized
DEBUG - 2017-04-14 11:18:00 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-04-14 11:18:00 --> Input Class Initialized
INFO - 2017-04-14 11:18:00 --> Language Class Initialized
INFO - 2017-04-14 11:18:00 --> Loader Class Initialized
INFO - 2017-04-14 11:18:00 --> Controller Class Initialized
INFO - 2017-04-14 11:18:00 --> Model Class Initialized
INFO - 2017-04-14 11:18:00 --> Database Driver Class Initialized
INFO - 2017-04-14 11:18:01 --> Model Class Initialized
INFO - 2017-04-14 11:18:01 --> Helper loaded: form_helper
INFO - 2017-04-14 11:18:01 --> Form Validation Class Initialized
INFO - 2017-04-14 11:18:01 --> Language file loaded: language/chinese/form_validation_lang.php
INFO - 2017-04-14 11:18:01 --> Final output sent to browser
DEBUG - 2017-04-14 11:18:01 --> Total execution time: 1.2608
INFO - 2017-04-14 11:18:34 --> Config Class Initialized
INFO - 2017-04-14 11:18:34 --> Hooks Class Initialized
DEBUG - 2017-04-14 11:18:34 --> UTF-8 Support Enabled
INFO - 2017-04-14 11:18:34 --> Utf8 Class Initialized
INFO - 2017-04-14 11:18:34 --> URI Class Initialized
INFO - 2017-04-14 11:18:34 --> Router Class Initialized
INFO - 2017-04-14 11:18:34 --> Output Class Initialized
INFO - 2017-04-14 11:18:34 --> Security Class Initialized
DEBUG - 2017-04-14 11:18:34 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-04-14 11:18:34 --> Input Class Initialized
INFO - 2017-04-14 11:18:34 --> Language Class Initialized
INFO - 2017-04-14 11:18:34 --> Loader Class Initialized
INFO - 2017-04-14 11:18:34 --> Controller Class Initialized
INFO - 2017-04-14 11:18:34 --> Model Class Initialized
INFO - 2017-04-14 11:18:34 --> Database Driver Class Initialized
INFO - 2017-04-14 11:18:35 --> Model Class Initialized
INFO - 2017-04-14 11:18:35 --> Helper loaded: form_helper
INFO - 2017-04-14 11:18:35 --> Form Validation Class Initialized
INFO - 2017-04-14 11:18:35 --> Language file loaded: language/chinese/form_validation_lang.php
INFO - 2017-04-14 11:18:36 --> Final output sent to browser
DEBUG - 2017-04-14 11:18:36 --> Total execution time: 1.2372
