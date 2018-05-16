<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

INFO - 2017-03-07 13:25:37 --> Config Class Initialized
INFO - 2017-03-07 13:25:37 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:25:37 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:25:37 --> Utf8 Class Initialized
INFO - 2017-03-07 13:25:37 --> URI Class Initialized
INFO - 2017-03-07 13:25:37 --> Router Class Initialized
INFO - 2017-03-07 13:25:37 --> Output Class Initialized
INFO - 2017-03-07 13:25:37 --> Security Class Initialized
DEBUG - 2017-03-07 13:25:37 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:25:37 --> Input Class Initialized
INFO - 2017-03-07 13:25:37 --> Language Class Initialized
INFO - 2017-03-07 13:25:37 --> Loader Class Initialized
INFO - 2017-03-07 13:25:37 --> Controller Class Initialized
INFO - 2017-03-07 13:25:37 --> Model Class Initialized
INFO - 2017-03-07 13:25:37 --> Database Driver Class Initialized
INFO - 2017-03-07 13:25:38 --> Model Class Initialized
INFO - 2017-03-07 13:25:38 --> Helper loaded: form_helper
INFO - 2017-03-07 13:25:38 --> Form Validation Class Initialized
INFO - 2017-03-07 13:25:38 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:25:38 --> Final output sent to browser
DEBUG - 2017-03-07 13:25:38 --> Total execution time: 1.0669
INFO - 2017-03-07 13:26:22 --> Config Class Initialized
INFO - 2017-03-07 13:26:22 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:26:22 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:26:22 --> Utf8 Class Initialized
INFO - 2017-03-07 13:26:22 --> URI Class Initialized
INFO - 2017-03-07 13:26:22 --> Router Class Initialized
INFO - 2017-03-07 13:26:22 --> Output Class Initialized
INFO - 2017-03-07 13:26:22 --> Security Class Initialized
DEBUG - 2017-03-07 13:26:22 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:26:22 --> Input Class Initialized
INFO - 2017-03-07 13:26:22 --> Language Class Initialized
INFO - 2017-03-07 13:26:22 --> Loader Class Initialized
INFO - 2017-03-07 13:26:22 --> Controller Class Initialized
INFO - 2017-03-07 13:26:22 --> Model Class Initialized
INFO - 2017-03-07 13:26:22 --> Database Driver Class Initialized
INFO - 2017-03-07 13:26:22 --> Model Class Initialized
INFO - 2017-03-07 13:26:22 --> Helper loaded: form_helper
INFO - 2017-03-07 13:26:22 --> Form Validation Class Initialized
INFO - 2017-03-07 13:26:22 --> Language file loaded: language/english/form_validation_lang.php
ERROR - 2017-03-07 13:26:23 --> Severity: Warning --> Illegal string offset 'question_no' F:\Work\GMP\GmpWeb\api\models\Test_model.php 216
ERROR - 2017-03-07 13:26:23 --> Severity: Warning --> Illegal string offset 'question_id' F:\Work\GMP\GmpWeb\api\models\Test_model.php 216
ERROR - 2017-03-07 13:26:23 --> Severity: Warning --> Illegal string offset 'category_id' F:\Work\GMP\GmpWeb\api\models\Test_model.php 216
ERROR - 2017-03-07 13:26:23 --> Severity: Warning --> Illegal string offset 'question_no' F:\Work\GMP\GmpWeb\api\models\Test_model.php 216
ERROR - 2017-03-07 13:26:23 --> Severity: Warning --> Illegal string offset 'question_id' F:\Work\GMP\GmpWeb\api\models\Test_model.php 216
ERROR - 2017-03-07 13:26:23 --> Severity: Warning --> Illegal string offset 'category_id' F:\Work\GMP\GmpWeb\api\models\Test_model.php 216
ERROR - 2017-03-07 13:26:23 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`gmp`.`test_result_detail`, CONSTRAINT `test_result_detail_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`)) - Invalid query: INSERT INTO `test_result_detail` (`test_result_id`, `user_id`, `test_id`, `no`, `question_id`, `category_id`) VALUES (1, '8', '16', 'G', 'G', 'G')
INFO - 2017-03-07 13:26:23 --> Language file loaded: language/english/db_lang.php
ERROR - 2017-03-07 13:26:23 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at F:\Work\GMP\GmpWeb\system\core\Exceptions.php:271) F:\Work\GMP\GmpWeb\system\core\Common.php 578
INFO - 2017-03-07 13:30:54 --> Config Class Initialized
INFO - 2017-03-07 13:30:54 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:30:54 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:30:54 --> Utf8 Class Initialized
INFO - 2017-03-07 13:30:54 --> URI Class Initialized
INFO - 2017-03-07 13:30:54 --> Router Class Initialized
INFO - 2017-03-07 13:30:54 --> Output Class Initialized
INFO - 2017-03-07 13:30:54 --> Security Class Initialized
DEBUG - 2017-03-07 13:30:54 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:30:54 --> Input Class Initialized
INFO - 2017-03-07 13:30:54 --> Language Class Initialized
INFO - 2017-03-07 13:30:54 --> Loader Class Initialized
INFO - 2017-03-07 13:30:54 --> Controller Class Initialized
INFO - 2017-03-07 13:30:54 --> Model Class Initialized
INFO - 2017-03-07 13:30:54 --> Database Driver Class Initialized
INFO - 2017-03-07 13:30:54 --> Model Class Initialized
INFO - 2017-03-07 13:30:54 --> Helper loaded: form_helper
INFO - 2017-03-07 13:30:54 --> Form Validation Class Initialized
INFO - 2017-03-07 13:30:54 --> Language file loaded: language/english/form_validation_lang.php
ERROR - 2017-03-07 13:30:54 --> Severity: Notice --> Undefined index: category_id F:\Work\GMP\GmpWeb\api\models\Test_model.php 216
ERROR - 2017-03-07 13:30:54 --> Query error: Column 'category_id' cannot be null - Invalid query: INSERT INTO `test_result_detail` (`test_result_id`, `user_id`, `test_id`, `no`, `question_id`, `category_id`) VALUES (1, '8', '16', 1, '102', NULL)
INFO - 2017-03-07 13:30:54 --> Language file loaded: language/english/db_lang.php
INFO - 2017-03-07 13:34:24 --> Config Class Initialized
INFO - 2017-03-07 13:34:24 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:34:24 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:34:24 --> Utf8 Class Initialized
INFO - 2017-03-07 13:34:24 --> URI Class Initialized
INFO - 2017-03-07 13:34:24 --> Router Class Initialized
INFO - 2017-03-07 13:34:24 --> Output Class Initialized
INFO - 2017-03-07 13:34:24 --> Security Class Initialized
DEBUG - 2017-03-07 13:34:24 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:34:24 --> Input Class Initialized
INFO - 2017-03-07 13:34:24 --> Language Class Initialized
INFO - 2017-03-07 13:34:24 --> Loader Class Initialized
INFO - 2017-03-07 13:34:24 --> Controller Class Initialized
INFO - 2017-03-07 13:34:24 --> Model Class Initialized
INFO - 2017-03-07 13:34:24 --> Database Driver Class Initialized
INFO - 2017-03-07 13:34:24 --> Model Class Initialized
INFO - 2017-03-07 13:34:24 --> Helper loaded: form_helper
INFO - 2017-03-07 13:34:24 --> Form Validation Class Initialized
INFO - 2017-03-07 13:34:24 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:34:26 --> Final output sent to browser
DEBUG - 2017-03-07 13:34:26 --> Total execution time: 1.5280
INFO - 2017-03-07 13:36:03 --> Config Class Initialized
INFO - 2017-03-07 13:36:03 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:36:03 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:36:03 --> Utf8 Class Initialized
INFO - 2017-03-07 13:36:03 --> URI Class Initialized
INFO - 2017-03-07 13:36:03 --> Router Class Initialized
INFO - 2017-03-07 13:36:03 --> Output Class Initialized
INFO - 2017-03-07 13:36:03 --> Security Class Initialized
DEBUG - 2017-03-07 13:36:03 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:36:03 --> Input Class Initialized
INFO - 2017-03-07 13:36:03 --> Language Class Initialized
INFO - 2017-03-07 13:36:03 --> Loader Class Initialized
INFO - 2017-03-07 13:36:03 --> Controller Class Initialized
INFO - 2017-03-07 13:36:03 --> Model Class Initialized
INFO - 2017-03-07 13:36:03 --> Database Driver Class Initialized
INFO - 2017-03-07 13:36:03 --> Model Class Initialized
INFO - 2017-03-07 13:36:03 --> Helper loaded: form_helper
INFO - 2017-03-07 13:36:03 --> Form Validation Class Initialized
INFO - 2017-03-07 13:36:03 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:36:03 --> Final output sent to browser
DEBUG - 2017-03-07 13:36:03 --> Total execution time: 0.1324
INFO - 2017-03-07 13:36:05 --> Config Class Initialized
INFO - 2017-03-07 13:36:05 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:36:05 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:36:05 --> Utf8 Class Initialized
INFO - 2017-03-07 13:36:05 --> URI Class Initialized
INFO - 2017-03-07 13:36:05 --> Router Class Initialized
INFO - 2017-03-07 13:36:05 --> Output Class Initialized
INFO - 2017-03-07 13:36:05 --> Security Class Initialized
DEBUG - 2017-03-07 13:36:05 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:36:05 --> Input Class Initialized
INFO - 2017-03-07 13:36:05 --> Language Class Initialized
INFO - 2017-03-07 13:36:05 --> Loader Class Initialized
INFO - 2017-03-07 13:36:05 --> Controller Class Initialized
INFO - 2017-03-07 13:36:05 --> Model Class Initialized
INFO - 2017-03-07 13:36:05 --> Database Driver Class Initialized
INFO - 2017-03-07 13:36:05 --> Model Class Initialized
INFO - 2017-03-07 13:36:05 --> Helper loaded: form_helper
INFO - 2017-03-07 13:36:05 --> Form Validation Class Initialized
INFO - 2017-03-07 13:36:05 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:36:05 --> Final output sent to browser
DEBUG - 2017-03-07 13:36:05 --> Total execution time: 0.1270
INFO - 2017-03-07 13:36:05 --> Config Class Initialized
INFO - 2017-03-07 13:36:05 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:36:05 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:36:05 --> Utf8 Class Initialized
INFO - 2017-03-07 13:36:05 --> URI Class Initialized
INFO - 2017-03-07 13:36:05 --> Router Class Initialized
INFO - 2017-03-07 13:36:05 --> Output Class Initialized
INFO - 2017-03-07 13:36:05 --> Security Class Initialized
DEBUG - 2017-03-07 13:36:05 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:36:05 --> Input Class Initialized
INFO - 2017-03-07 13:36:05 --> Language Class Initialized
INFO - 2017-03-07 13:36:05 --> Loader Class Initialized
INFO - 2017-03-07 13:36:05 --> Controller Class Initialized
INFO - 2017-03-07 13:36:05 --> Model Class Initialized
INFO - 2017-03-07 13:36:05 --> Database Driver Class Initialized
INFO - 2017-03-07 13:36:06 --> Model Class Initialized
INFO - 2017-03-07 13:36:06 --> Helper loaded: form_helper
INFO - 2017-03-07 13:36:06 --> Form Validation Class Initialized
INFO - 2017-03-07 13:36:06 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:36:06 --> Config Class Initialized
INFO - 2017-03-07 13:36:06 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:36:06 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:36:06 --> Utf8 Class Initialized
INFO - 2017-03-07 13:36:06 --> URI Class Initialized
INFO - 2017-03-07 13:36:06 --> Router Class Initialized
INFO - 2017-03-07 13:36:06 --> Output Class Initialized
INFO - 2017-03-07 13:36:06 --> Security Class Initialized
DEBUG - 2017-03-07 13:36:06 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:36:06 --> Input Class Initialized
INFO - 2017-03-07 13:36:06 --> Final output sent to browser
INFO - 2017-03-07 13:36:06 --> Language Class Initialized
DEBUG - 2017-03-07 13:36:06 --> Total execution time: 0.3134
INFO - 2017-03-07 13:36:06 --> Loader Class Initialized
INFO - 2017-03-07 13:36:06 --> Controller Class Initialized
INFO - 2017-03-07 13:36:06 --> Model Class Initialized
INFO - 2017-03-07 13:36:06 --> Database Driver Class Initialized
INFO - 2017-03-07 13:36:06 --> Model Class Initialized
INFO - 2017-03-07 13:36:06 --> Helper loaded: form_helper
INFO - 2017-03-07 13:36:06 --> Form Validation Class Initialized
INFO - 2017-03-07 13:36:06 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:36:06 --> Final output sent to browser
DEBUG - 2017-03-07 13:36:06 --> Total execution time: 0.1785
INFO - 2017-03-07 13:41:15 --> Config Class Initialized
INFO - 2017-03-07 13:41:15 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:41:15 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:41:15 --> Utf8 Class Initialized
INFO - 2017-03-07 13:41:15 --> URI Class Initialized
INFO - 2017-03-07 13:41:15 --> Router Class Initialized
INFO - 2017-03-07 13:41:15 --> Output Class Initialized
INFO - 2017-03-07 13:41:15 --> Security Class Initialized
DEBUG - 2017-03-07 13:41:15 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:41:15 --> Input Class Initialized
INFO - 2017-03-07 13:41:15 --> Language Class Initialized
INFO - 2017-03-07 13:41:15 --> Loader Class Initialized
INFO - 2017-03-07 13:41:15 --> Controller Class Initialized
INFO - 2017-03-07 13:41:15 --> Model Class Initialized
INFO - 2017-03-07 13:41:15 --> Database Driver Class Initialized
INFO - 2017-03-07 13:41:15 --> Model Class Initialized
INFO - 2017-03-07 13:41:15 --> Helper loaded: form_helper
INFO - 2017-03-07 13:41:15 --> Form Validation Class Initialized
INFO - 2017-03-07 13:41:15 --> Language file loaded: language/english/form_validation_lang.php
ERROR - 2017-03-07 13:41:15 --> Severity: Warning --> Invalid argument supplied for foreach() F:\Work\GMP\GmpWeb\api\models\Test_model.php 115
INFO - 2017-03-07 13:41:15 --> Final output sent to browser
DEBUG - 2017-03-07 13:41:15 --> Total execution time: 0.2412
INFO - 2017-03-07 13:42:18 --> Config Class Initialized
INFO - 2017-03-07 13:42:18 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:42:18 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:42:18 --> Utf8 Class Initialized
INFO - 2017-03-07 13:42:18 --> URI Class Initialized
INFO - 2017-03-07 13:42:18 --> Router Class Initialized
INFO - 2017-03-07 13:42:18 --> Output Class Initialized
INFO - 2017-03-07 13:42:18 --> Security Class Initialized
DEBUG - 2017-03-07 13:42:18 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:42:18 --> Input Class Initialized
INFO - 2017-03-07 13:42:18 --> Language Class Initialized
INFO - 2017-03-07 13:42:18 --> Loader Class Initialized
INFO - 2017-03-07 13:42:18 --> Controller Class Initialized
INFO - 2017-03-07 13:42:18 --> Model Class Initialized
INFO - 2017-03-07 13:42:18 --> Database Driver Class Initialized
INFO - 2017-03-07 13:42:18 --> Model Class Initialized
INFO - 2017-03-07 13:42:18 --> Helper loaded: form_helper
INFO - 2017-03-07 13:42:18 --> Form Validation Class Initialized
INFO - 2017-03-07 13:42:18 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:42:18 --> Final output sent to browser
DEBUG - 2017-03-07 13:42:18 --> Total execution time: 0.1741
INFO - 2017-03-07 13:42:23 --> Config Class Initialized
INFO - 2017-03-07 13:42:23 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:42:23 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:42:23 --> Utf8 Class Initialized
INFO - 2017-03-07 13:42:23 --> URI Class Initialized
INFO - 2017-03-07 13:42:23 --> Router Class Initialized
INFO - 2017-03-07 13:42:23 --> Output Class Initialized
INFO - 2017-03-07 13:42:23 --> Security Class Initialized
DEBUG - 2017-03-07 13:42:23 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:42:23 --> Input Class Initialized
INFO - 2017-03-07 13:42:23 --> Language Class Initialized
INFO - 2017-03-07 13:42:23 --> Loader Class Initialized
INFO - 2017-03-07 13:42:23 --> Controller Class Initialized
INFO - 2017-03-07 13:42:23 --> Model Class Initialized
INFO - 2017-03-07 13:42:23 --> Database Driver Class Initialized
INFO - 2017-03-07 13:42:23 --> Model Class Initialized
INFO - 2017-03-07 13:42:23 --> Helper loaded: form_helper
INFO - 2017-03-07 13:42:23 --> Form Validation Class Initialized
INFO - 2017-03-07 13:42:23 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:42:23 --> Final output sent to browser
DEBUG - 2017-03-07 13:42:23 --> Total execution time: 0.1459
INFO - 2017-03-07 13:43:19 --> Config Class Initialized
INFO - 2017-03-07 13:43:19 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:43:19 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:43:19 --> Utf8 Class Initialized
INFO - 2017-03-07 13:43:19 --> URI Class Initialized
INFO - 2017-03-07 13:43:19 --> Router Class Initialized
INFO - 2017-03-07 13:43:19 --> Output Class Initialized
INFO - 2017-03-07 13:43:19 --> Security Class Initialized
DEBUG - 2017-03-07 13:43:19 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:43:19 --> Input Class Initialized
INFO - 2017-03-07 13:43:19 --> Language Class Initialized
INFO - 2017-03-07 13:43:19 --> Loader Class Initialized
INFO - 2017-03-07 13:43:19 --> Controller Class Initialized
INFO - 2017-03-07 13:43:19 --> Model Class Initialized
INFO - 2017-03-07 13:43:19 --> Database Driver Class Initialized
INFO - 2017-03-07 13:43:19 --> Model Class Initialized
INFO - 2017-03-07 13:43:19 --> Helper loaded: form_helper
INFO - 2017-03-07 13:43:19 --> Form Validation Class Initialized
INFO - 2017-03-07 13:43:19 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:43:19 --> Final output sent to browser
DEBUG - 2017-03-07 13:43:19 --> Total execution time: 0.1488
INFO - 2017-03-07 13:43:19 --> Config Class Initialized
INFO - 2017-03-07 13:43:19 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:43:19 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:43:19 --> Utf8 Class Initialized
INFO - 2017-03-07 13:43:19 --> URI Class Initialized
INFO - 2017-03-07 13:43:19 --> Router Class Initialized
INFO - 2017-03-07 13:43:19 --> Output Class Initialized
INFO - 2017-03-07 13:43:19 --> Security Class Initialized
DEBUG - 2017-03-07 13:43:19 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:43:19 --> Input Class Initialized
INFO - 2017-03-07 13:43:19 --> Language Class Initialized
INFO - 2017-03-07 13:43:19 --> Loader Class Initialized
INFO - 2017-03-07 13:43:19 --> Controller Class Initialized
INFO - 2017-03-07 13:43:19 --> Model Class Initialized
INFO - 2017-03-07 13:43:19 --> Database Driver Class Initialized
INFO - 2017-03-07 13:43:19 --> Model Class Initialized
INFO - 2017-03-07 13:43:19 --> Helper loaded: form_helper
INFO - 2017-03-07 13:43:19 --> Form Validation Class Initialized
INFO - 2017-03-07 13:43:19 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:43:19 --> Final output sent to browser
DEBUG - 2017-03-07 13:43:19 --> Total execution time: 0.1417
INFO - 2017-03-07 13:43:19 --> Config Class Initialized
INFO - 2017-03-07 13:43:19 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:43:19 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:43:19 --> Utf8 Class Initialized
INFO - 2017-03-07 13:43:19 --> URI Class Initialized
INFO - 2017-03-07 13:43:19 --> Router Class Initialized
INFO - 2017-03-07 13:43:19 --> Output Class Initialized
INFO - 2017-03-07 13:43:19 --> Security Class Initialized
DEBUG - 2017-03-07 13:43:19 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:43:19 --> Input Class Initialized
INFO - 2017-03-07 13:43:19 --> Language Class Initialized
INFO - 2017-03-07 13:43:19 --> Loader Class Initialized
INFO - 2017-03-07 13:43:19 --> Controller Class Initialized
INFO - 2017-03-07 13:43:19 --> Model Class Initialized
INFO - 2017-03-07 13:43:19 --> Database Driver Class Initialized
INFO - 2017-03-07 13:43:19 --> Model Class Initialized
INFO - 2017-03-07 13:43:19 --> Helper loaded: form_helper
INFO - 2017-03-07 13:43:19 --> Form Validation Class Initialized
INFO - 2017-03-07 13:43:19 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:43:19 --> Final output sent to browser
DEBUG - 2017-03-07 13:43:19 --> Total execution time: 0.1523
INFO - 2017-03-07 13:44:53 --> Config Class Initialized
INFO - 2017-03-07 13:44:53 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:44:53 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:44:53 --> Utf8 Class Initialized
INFO - 2017-03-07 13:44:53 --> URI Class Initialized
INFO - 2017-03-07 13:44:53 --> Router Class Initialized
INFO - 2017-03-07 13:44:53 --> Output Class Initialized
INFO - 2017-03-07 13:44:53 --> Security Class Initialized
DEBUG - 2017-03-07 13:44:53 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:44:53 --> Input Class Initialized
INFO - 2017-03-07 13:44:53 --> Language Class Initialized
INFO - 2017-03-07 13:44:53 --> Loader Class Initialized
INFO - 2017-03-07 13:44:53 --> Controller Class Initialized
INFO - 2017-03-07 13:44:53 --> Model Class Initialized
INFO - 2017-03-07 13:44:53 --> Database Driver Class Initialized
INFO - 2017-03-07 13:44:53 --> Model Class Initialized
INFO - 2017-03-07 13:44:53 --> Helper loaded: form_helper
INFO - 2017-03-07 13:44:53 --> Form Validation Class Initialized
INFO - 2017-03-07 13:44:53 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:44:53 --> Final output sent to browser
DEBUG - 2017-03-07 13:44:53 --> Total execution time: 0.5618
INFO - 2017-03-07 13:47:24 --> Config Class Initialized
INFO - 2017-03-07 13:47:24 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:47:24 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:47:24 --> Utf8 Class Initialized
INFO - 2017-03-07 13:47:24 --> URI Class Initialized
INFO - 2017-03-07 13:47:24 --> Router Class Initialized
INFO - 2017-03-07 13:47:24 --> Output Class Initialized
INFO - 2017-03-07 13:47:24 --> Security Class Initialized
DEBUG - 2017-03-07 13:47:24 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:47:24 --> Input Class Initialized
INFO - 2017-03-07 13:47:24 --> Language Class Initialized
INFO - 2017-03-07 13:47:24 --> Loader Class Initialized
INFO - 2017-03-07 13:47:24 --> Controller Class Initialized
INFO - 2017-03-07 13:47:24 --> Model Class Initialized
INFO - 2017-03-07 13:47:24 --> Database Driver Class Initialized
INFO - 2017-03-07 13:47:24 --> Model Class Initialized
INFO - 2017-03-07 13:47:24 --> Helper loaded: form_helper
INFO - 2017-03-07 13:47:24 --> Form Validation Class Initialized
INFO - 2017-03-07 13:47:24 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:47:24 --> Final output sent to browser
DEBUG - 2017-03-07 13:47:24 --> Total execution time: 0.4819
INFO - 2017-03-07 13:47:33 --> Config Class Initialized
INFO - 2017-03-07 13:47:33 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:47:33 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:47:33 --> Utf8 Class Initialized
INFO - 2017-03-07 13:47:33 --> URI Class Initialized
INFO - 2017-03-07 13:47:33 --> Router Class Initialized
INFO - 2017-03-07 13:47:33 --> Output Class Initialized
INFO - 2017-03-07 13:47:33 --> Security Class Initialized
DEBUG - 2017-03-07 13:47:33 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:47:33 --> Input Class Initialized
INFO - 2017-03-07 13:47:33 --> Language Class Initialized
INFO - 2017-03-07 13:47:33 --> Loader Class Initialized
INFO - 2017-03-07 13:47:33 --> Controller Class Initialized
INFO - 2017-03-07 13:47:33 --> Model Class Initialized
INFO - 2017-03-07 13:47:33 --> Database Driver Class Initialized
INFO - 2017-03-07 13:47:33 --> Model Class Initialized
INFO - 2017-03-07 13:47:33 --> Helper loaded: form_helper
INFO - 2017-03-07 13:47:33 --> Form Validation Class Initialized
INFO - 2017-03-07 13:47:33 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:47:34 --> Final output sent to browser
DEBUG - 2017-03-07 13:47:34 --> Total execution time: 0.2786
INFO - 2017-03-07 13:47:47 --> Config Class Initialized
INFO - 2017-03-07 13:47:47 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:47:47 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:47:47 --> Utf8 Class Initialized
INFO - 2017-03-07 13:47:47 --> URI Class Initialized
INFO - 2017-03-07 13:47:47 --> Router Class Initialized
INFO - 2017-03-07 13:47:47 --> Output Class Initialized
INFO - 2017-03-07 13:47:47 --> Security Class Initialized
DEBUG - 2017-03-07 13:47:47 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:47:47 --> Input Class Initialized
INFO - 2017-03-07 13:47:47 --> Language Class Initialized
INFO - 2017-03-07 13:47:47 --> Loader Class Initialized
INFO - 2017-03-07 13:47:47 --> Controller Class Initialized
INFO - 2017-03-07 13:47:47 --> Model Class Initialized
INFO - 2017-03-07 13:47:47 --> Database Driver Class Initialized
INFO - 2017-03-07 13:47:47 --> Model Class Initialized
INFO - 2017-03-07 13:47:47 --> Helper loaded: form_helper
INFO - 2017-03-07 13:47:47 --> Form Validation Class Initialized
INFO - 2017-03-07 13:47:47 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:47:47 --> Final output sent to browser
DEBUG - 2017-03-07 13:47:47 --> Total execution time: 0.4182
INFO - 2017-03-07 13:47:50 --> Config Class Initialized
INFO - 2017-03-07 13:47:50 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:47:50 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:47:50 --> Utf8 Class Initialized
INFO - 2017-03-07 13:47:50 --> URI Class Initialized
INFO - 2017-03-07 13:47:50 --> Router Class Initialized
INFO - 2017-03-07 13:47:50 --> Output Class Initialized
INFO - 2017-03-07 13:47:50 --> Security Class Initialized
DEBUG - 2017-03-07 13:47:50 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:47:50 --> Input Class Initialized
INFO - 2017-03-07 13:47:50 --> Language Class Initialized
INFO - 2017-03-07 13:47:50 --> Loader Class Initialized
INFO - 2017-03-07 13:47:50 --> Controller Class Initialized
INFO - 2017-03-07 13:47:50 --> Model Class Initialized
INFO - 2017-03-07 13:47:50 --> Database Driver Class Initialized
INFO - 2017-03-07 13:47:50 --> Model Class Initialized
INFO - 2017-03-07 13:47:50 --> Helper loaded: form_helper
INFO - 2017-03-07 13:47:50 --> Form Validation Class Initialized
INFO - 2017-03-07 13:47:50 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:47:51 --> Final output sent to browser
DEBUG - 2017-03-07 13:47:51 --> Total execution time: 0.4113
INFO - 2017-03-07 13:48:05 --> Config Class Initialized
INFO - 2017-03-07 13:48:05 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:48:05 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:48:05 --> Utf8 Class Initialized
INFO - 2017-03-07 13:48:05 --> URI Class Initialized
INFO - 2017-03-07 13:48:05 --> Router Class Initialized
INFO - 2017-03-07 13:48:05 --> Output Class Initialized
INFO - 2017-03-07 13:48:05 --> Security Class Initialized
DEBUG - 2017-03-07 13:48:05 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:48:05 --> Input Class Initialized
INFO - 2017-03-07 13:48:05 --> Language Class Initialized
INFO - 2017-03-07 13:48:05 --> Loader Class Initialized
INFO - 2017-03-07 13:48:05 --> Controller Class Initialized
INFO - 2017-03-07 13:48:05 --> Model Class Initialized
INFO - 2017-03-07 13:48:05 --> Database Driver Class Initialized
INFO - 2017-03-07 13:48:05 --> Model Class Initialized
INFO - 2017-03-07 13:48:05 --> Helper loaded: form_helper
INFO - 2017-03-07 13:48:05 --> Form Validation Class Initialized
INFO - 2017-03-07 13:48:05 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:48:05 --> Final output sent to browser
DEBUG - 2017-03-07 13:48:05 --> Total execution time: 0.2784
INFO - 2017-03-07 13:49:20 --> Config Class Initialized
INFO - 2017-03-07 13:49:20 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:49:20 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:49:20 --> Utf8 Class Initialized
INFO - 2017-03-07 13:49:20 --> URI Class Initialized
INFO - 2017-03-07 13:49:20 --> Router Class Initialized
INFO - 2017-03-07 13:49:20 --> Output Class Initialized
INFO - 2017-03-07 13:49:20 --> Security Class Initialized
DEBUG - 2017-03-07 13:49:20 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:49:20 --> Input Class Initialized
INFO - 2017-03-07 13:49:20 --> Language Class Initialized
INFO - 2017-03-07 13:49:20 --> Loader Class Initialized
INFO - 2017-03-07 13:49:20 --> Controller Class Initialized
INFO - 2017-03-07 13:49:20 --> Model Class Initialized
INFO - 2017-03-07 13:49:20 --> Database Driver Class Initialized
INFO - 2017-03-07 13:49:20 --> Model Class Initialized
INFO - 2017-03-07 13:49:20 --> Helper loaded: form_helper
INFO - 2017-03-07 13:49:20 --> Form Validation Class Initialized
INFO - 2017-03-07 13:49:20 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:49:21 --> Final output sent to browser
DEBUG - 2017-03-07 13:49:21 --> Total execution time: 0.6393
INFO - 2017-03-07 13:51:10 --> Config Class Initialized
INFO - 2017-03-07 13:51:10 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:51:10 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:51:10 --> Utf8 Class Initialized
INFO - 2017-03-07 13:51:10 --> URI Class Initialized
INFO - 2017-03-07 13:51:10 --> Router Class Initialized
INFO - 2017-03-07 13:51:10 --> Output Class Initialized
INFO - 2017-03-07 13:51:10 --> Security Class Initialized
DEBUG - 2017-03-07 13:51:10 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:51:10 --> Input Class Initialized
INFO - 2017-03-07 13:51:10 --> Language Class Initialized
INFO - 2017-03-07 13:51:10 --> Loader Class Initialized
INFO - 2017-03-07 13:51:10 --> Controller Class Initialized
INFO - 2017-03-07 13:51:10 --> Model Class Initialized
INFO - 2017-03-07 13:51:10 --> Database Driver Class Initialized
INFO - 2017-03-07 13:51:10 --> Model Class Initialized
INFO - 2017-03-07 13:51:10 --> Helper loaded: form_helper
INFO - 2017-03-07 13:51:10 --> Form Validation Class Initialized
INFO - 2017-03-07 13:51:10 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:51:10 --> Final output sent to browser
DEBUG - 2017-03-07 13:51:10 --> Total execution time: 0.2590
INFO - 2017-03-07 13:59:34 --> Config Class Initialized
INFO - 2017-03-07 13:59:34 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:59:34 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:59:34 --> Utf8 Class Initialized
INFO - 2017-03-07 13:59:34 --> URI Class Initialized
INFO - 2017-03-07 13:59:34 --> Router Class Initialized
INFO - 2017-03-07 13:59:34 --> Output Class Initialized
INFO - 2017-03-07 13:59:34 --> Security Class Initialized
DEBUG - 2017-03-07 13:59:34 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:59:34 --> Input Class Initialized
INFO - 2017-03-07 13:59:34 --> Language Class Initialized
INFO - 2017-03-07 13:59:34 --> Loader Class Initialized
INFO - 2017-03-07 13:59:34 --> Controller Class Initialized
INFO - 2017-03-07 13:59:34 --> Model Class Initialized
INFO - 2017-03-07 13:59:34 --> Database Driver Class Initialized
INFO - 2017-03-07 13:59:34 --> Final output sent to browser
DEBUG - 2017-03-07 13:59:34 --> Total execution time: 0.1609
INFO - 2017-03-07 13:59:41 --> Config Class Initialized
INFO - 2017-03-07 13:59:41 --> Hooks Class Initialized
DEBUG - 2017-03-07 13:59:41 --> UTF-8 Support Enabled
INFO - 2017-03-07 13:59:41 --> Utf8 Class Initialized
INFO - 2017-03-07 13:59:41 --> URI Class Initialized
INFO - 2017-03-07 13:59:41 --> Router Class Initialized
INFO - 2017-03-07 13:59:41 --> Output Class Initialized
INFO - 2017-03-07 13:59:41 --> Security Class Initialized
DEBUG - 2017-03-07 13:59:41 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 13:59:41 --> Input Class Initialized
INFO - 2017-03-07 13:59:41 --> Language Class Initialized
INFO - 2017-03-07 13:59:41 --> Loader Class Initialized
INFO - 2017-03-07 13:59:41 --> Controller Class Initialized
INFO - 2017-03-07 13:59:41 --> Model Class Initialized
INFO - 2017-03-07 13:59:41 --> Database Driver Class Initialized
INFO - 2017-03-07 13:59:41 --> Model Class Initialized
INFO - 2017-03-07 13:59:41 --> Helper loaded: form_helper
INFO - 2017-03-07 13:59:41 --> Form Validation Class Initialized
INFO - 2017-03-07 13:59:41 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 13:59:41 --> Final output sent to browser
DEBUG - 2017-03-07 13:59:41 --> Total execution time: 0.1558
INFO - 2017-03-07 14:00:16 --> Config Class Initialized
INFO - 2017-03-07 14:00:16 --> Hooks Class Initialized
DEBUG - 2017-03-07 14:00:16 --> UTF-8 Support Enabled
INFO - 2017-03-07 14:00:16 --> Utf8 Class Initialized
INFO - 2017-03-07 14:00:16 --> URI Class Initialized
INFO - 2017-03-07 14:00:16 --> Router Class Initialized
INFO - 2017-03-07 14:00:16 --> Output Class Initialized
INFO - 2017-03-07 14:00:16 --> Security Class Initialized
DEBUG - 2017-03-07 14:00:16 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 14:00:16 --> Input Class Initialized
INFO - 2017-03-07 14:00:16 --> Language Class Initialized
INFO - 2017-03-07 14:00:16 --> Loader Class Initialized
INFO - 2017-03-07 14:00:16 --> Controller Class Initialized
INFO - 2017-03-07 14:00:16 --> Model Class Initialized
INFO - 2017-03-07 14:00:16 --> Database Driver Class Initialized
INFO - 2017-03-07 14:00:16 --> Model Class Initialized
INFO - 2017-03-07 14:00:16 --> Helper loaded: form_helper
INFO - 2017-03-07 14:00:16 --> Form Validation Class Initialized
INFO - 2017-03-07 14:00:16 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 14:00:16 --> Final output sent to browser
DEBUG - 2017-03-07 14:00:16 --> Total execution time: 0.1673
INFO - 2017-03-07 14:10:47 --> Config Class Initialized
INFO - 2017-03-07 14:10:47 --> Hooks Class Initialized
DEBUG - 2017-03-07 14:10:47 --> UTF-8 Support Enabled
INFO - 2017-03-07 14:10:47 --> Utf8 Class Initialized
INFO - 2017-03-07 14:10:47 --> URI Class Initialized
INFO - 2017-03-07 14:10:47 --> Router Class Initialized
INFO - 2017-03-07 14:10:47 --> Output Class Initialized
INFO - 2017-03-07 14:10:47 --> Security Class Initialized
DEBUG - 2017-03-07 14:10:47 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 14:10:47 --> Input Class Initialized
INFO - 2017-03-07 14:10:47 --> Language Class Initialized
INFO - 2017-03-07 14:10:47 --> Loader Class Initialized
INFO - 2017-03-07 14:10:47 --> Controller Class Initialized
INFO - 2017-03-07 14:10:47 --> Model Class Initialized
INFO - 2017-03-07 14:10:47 --> Database Driver Class Initialized
INFO - 2017-03-07 14:10:47 --> Model Class Initialized
INFO - 2017-03-07 14:10:47 --> Model Class Initialized
INFO - 2017-03-07 14:10:47 --> Helper loaded: form_helper
INFO - 2017-03-07 14:10:47 --> Form Validation Class Initialized
INFO - 2017-03-07 14:10:47 --> Language file loaded: language/english/form_validation_lang.php
ERROR - 2017-03-07 14:10:48 --> Severity: Error --> Call to undefined method Test_model::update_test_result_detail() F:\Work\GMP\GmpWeb\api\controllers\Test.php 140
INFO - 2017-03-07 14:10:53 --> Config Class Initialized
INFO - 2017-03-07 14:10:53 --> Hooks Class Initialized
DEBUG - 2017-03-07 14:10:53 --> UTF-8 Support Enabled
INFO - 2017-03-07 14:10:53 --> Utf8 Class Initialized
INFO - 2017-03-07 14:10:53 --> URI Class Initialized
INFO - 2017-03-07 14:10:53 --> Router Class Initialized
INFO - 2017-03-07 14:10:53 --> Output Class Initialized
INFO - 2017-03-07 14:10:53 --> Security Class Initialized
DEBUG - 2017-03-07 14:10:53 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 14:10:53 --> Input Class Initialized
INFO - 2017-03-07 14:10:53 --> Language Class Initialized
INFO - 2017-03-07 14:10:53 --> Loader Class Initialized
INFO - 2017-03-07 14:10:53 --> Controller Class Initialized
INFO - 2017-03-07 14:10:53 --> Model Class Initialized
INFO - 2017-03-07 14:10:53 --> Database Driver Class Initialized
INFO - 2017-03-07 14:10:53 --> Model Class Initialized
INFO - 2017-03-07 14:10:53 --> Model Class Initialized
INFO - 2017-03-07 14:10:53 --> Helper loaded: form_helper
INFO - 2017-03-07 14:10:53 --> Form Validation Class Initialized
INFO - 2017-03-07 14:10:53 --> Language file loaded: language/english/form_validation_lang.php
ERROR - 2017-03-07 14:10:53 --> Severity: Error --> Call to undefined method Test_model::update_test_result_detail() F:\Work\GMP\GmpWeb\api\controllers\Test.php 140
INFO - 2017-03-07 14:12:22 --> Config Class Initialized
INFO - 2017-03-07 14:12:22 --> Hooks Class Initialized
DEBUG - 2017-03-07 14:12:22 --> UTF-8 Support Enabled
INFO - 2017-03-07 14:12:22 --> Utf8 Class Initialized
INFO - 2017-03-07 14:12:22 --> URI Class Initialized
INFO - 2017-03-07 14:12:22 --> Router Class Initialized
INFO - 2017-03-07 14:12:22 --> Output Class Initialized
INFO - 2017-03-07 14:12:22 --> Security Class Initialized
DEBUG - 2017-03-07 14:12:22 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 14:12:22 --> Input Class Initialized
INFO - 2017-03-07 14:12:22 --> Language Class Initialized
INFO - 2017-03-07 14:12:22 --> Loader Class Initialized
INFO - 2017-03-07 14:12:22 --> Controller Class Initialized
INFO - 2017-03-07 14:12:22 --> Model Class Initialized
INFO - 2017-03-07 14:12:22 --> Database Driver Class Initialized
INFO - 2017-03-07 14:12:22 --> Model Class Initialized
INFO - 2017-03-07 14:12:22 --> Model Class Initialized
INFO - 2017-03-07 14:12:22 --> Helper loaded: form_helper
INFO - 2017-03-07 14:12:22 --> Form Validation Class Initialized
INFO - 2017-03-07 14:12:22 --> Language file loaded: language/english/form_validation_lang.php
ERROR - 2017-03-07 14:12:22 --> Severity: Notice --> Undefined variable: condtion F:\Work\GMP\GmpWeb\api\models\Test_model.php 176
INFO - 2017-03-07 14:12:22 --> Final output sent to browser
DEBUG - 2017-03-07 14:12:22 --> Total execution time: 0.5112
INFO - 2017-03-07 14:12:54 --> Config Class Initialized
INFO - 2017-03-07 14:12:54 --> Hooks Class Initialized
DEBUG - 2017-03-07 14:12:54 --> UTF-8 Support Enabled
INFO - 2017-03-07 14:12:54 --> Utf8 Class Initialized
INFO - 2017-03-07 14:12:54 --> URI Class Initialized
INFO - 2017-03-07 14:12:54 --> Router Class Initialized
INFO - 2017-03-07 14:12:54 --> Output Class Initialized
INFO - 2017-03-07 14:12:54 --> Security Class Initialized
DEBUG - 2017-03-07 14:12:54 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 14:12:54 --> Input Class Initialized
INFO - 2017-03-07 14:12:54 --> Language Class Initialized
INFO - 2017-03-07 14:12:54 --> Loader Class Initialized
INFO - 2017-03-07 14:12:54 --> Controller Class Initialized
INFO - 2017-03-07 14:12:54 --> Model Class Initialized
INFO - 2017-03-07 14:12:54 --> Database Driver Class Initialized
INFO - 2017-03-07 14:12:54 --> Model Class Initialized
INFO - 2017-03-07 14:12:54 --> Model Class Initialized
INFO - 2017-03-07 14:12:54 --> Helper loaded: form_helper
INFO - 2017-03-07 14:12:54 --> Form Validation Class Initialized
INFO - 2017-03-07 14:12:54 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 14:12:54 --> Final output sent to browser
DEBUG - 2017-03-07 14:12:54 --> Total execution time: 0.2242
INFO - 2017-03-07 14:15:02 --> Config Class Initialized
INFO - 2017-03-07 14:15:02 --> Hooks Class Initialized
DEBUG - 2017-03-07 14:15:02 --> UTF-8 Support Enabled
INFO - 2017-03-07 14:15:02 --> Utf8 Class Initialized
INFO - 2017-03-07 14:15:02 --> URI Class Initialized
INFO - 2017-03-07 14:15:02 --> Router Class Initialized
INFO - 2017-03-07 14:15:02 --> Output Class Initialized
INFO - 2017-03-07 14:15:02 --> Security Class Initialized
DEBUG - 2017-03-07 14:15:02 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 14:15:02 --> Input Class Initialized
INFO - 2017-03-07 14:15:02 --> Language Class Initialized
INFO - 2017-03-07 14:15:02 --> Loader Class Initialized
INFO - 2017-03-07 14:15:02 --> Controller Class Initialized
INFO - 2017-03-07 14:15:02 --> Model Class Initialized
INFO - 2017-03-07 14:15:02 --> Database Driver Class Initialized
INFO - 2017-03-07 14:15:02 --> Model Class Initialized
INFO - 2017-03-07 14:15:02 --> Model Class Initialized
INFO - 2017-03-07 14:15:02 --> Helper loaded: form_helper
INFO - 2017-03-07 14:15:02 --> Form Validation Class Initialized
INFO - 2017-03-07 14:15:02 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 14:15:02 --> Final output sent to browser
DEBUG - 2017-03-07 14:15:02 --> Total execution time: 0.1585
INFO - 2017-03-07 14:15:43 --> Config Class Initialized
INFO - 2017-03-07 14:15:43 --> Hooks Class Initialized
DEBUG - 2017-03-07 14:15:43 --> UTF-8 Support Enabled
INFO - 2017-03-07 14:15:43 --> Utf8 Class Initialized
INFO - 2017-03-07 14:15:43 --> URI Class Initialized
INFO - 2017-03-07 14:15:43 --> Router Class Initialized
INFO - 2017-03-07 14:15:43 --> Output Class Initialized
INFO - 2017-03-07 14:15:43 --> Security Class Initialized
DEBUG - 2017-03-07 14:15:43 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 14:15:43 --> Input Class Initialized
INFO - 2017-03-07 14:15:43 --> Language Class Initialized
INFO - 2017-03-07 14:15:43 --> Loader Class Initialized
INFO - 2017-03-07 14:15:43 --> Controller Class Initialized
INFO - 2017-03-07 14:15:43 --> Model Class Initialized
INFO - 2017-03-07 14:15:43 --> Database Driver Class Initialized
INFO - 2017-03-07 14:15:43 --> Model Class Initialized
INFO - 2017-03-07 14:15:43 --> Model Class Initialized
INFO - 2017-03-07 14:15:43 --> Helper loaded: form_helper
INFO - 2017-03-07 14:15:43 --> Form Validation Class Initialized
INFO - 2017-03-07 14:15:43 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 14:15:43 --> Final output sent to browser
DEBUG - 2017-03-07 14:15:43 --> Total execution time: 0.1568
INFO - 2017-03-07 14:32:20 --> Config Class Initialized
INFO - 2017-03-07 14:32:20 --> Hooks Class Initialized
DEBUG - 2017-03-07 14:32:20 --> UTF-8 Support Enabled
INFO - 2017-03-07 14:32:20 --> Utf8 Class Initialized
INFO - 2017-03-07 14:32:20 --> URI Class Initialized
INFO - 2017-03-07 14:32:20 --> Router Class Initialized
INFO - 2017-03-07 14:32:20 --> Output Class Initialized
INFO - 2017-03-07 14:32:20 --> Security Class Initialized
DEBUG - 2017-03-07 14:32:20 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 14:32:20 --> Input Class Initialized
INFO - 2017-03-07 14:32:20 --> Language Class Initialized
INFO - 2017-03-07 14:32:20 --> Loader Class Initialized
INFO - 2017-03-07 14:32:20 --> Controller Class Initialized
INFO - 2017-03-07 14:32:20 --> Model Class Initialized
INFO - 2017-03-07 14:32:20 --> Database Driver Class Initialized
INFO - 2017-03-07 14:32:20 --> Model Class Initialized
INFO - 2017-03-07 14:32:20 --> Model Class Initialized
INFO - 2017-03-07 14:32:20 --> Helper loaded: form_helper
INFO - 2017-03-07 14:32:20 --> Form Validation Class Initialized
INFO - 2017-03-07 14:32:20 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 14:32:20 --> Final output sent to browser
DEBUG - 2017-03-07 14:32:20 --> Total execution time: 0.1311
INFO - 2017-03-07 14:32:24 --> Config Class Initialized
INFO - 2017-03-07 14:32:24 --> Hooks Class Initialized
DEBUG - 2017-03-07 14:32:24 --> UTF-8 Support Enabled
INFO - 2017-03-07 14:32:24 --> Utf8 Class Initialized
INFO - 2017-03-07 14:32:24 --> URI Class Initialized
INFO - 2017-03-07 14:32:24 --> Router Class Initialized
INFO - 2017-03-07 14:32:24 --> Output Class Initialized
INFO - 2017-03-07 14:32:24 --> Security Class Initialized
DEBUG - 2017-03-07 14:32:24 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 14:32:24 --> Input Class Initialized
INFO - 2017-03-07 14:32:24 --> Language Class Initialized
INFO - 2017-03-07 14:32:24 --> Loader Class Initialized
INFO - 2017-03-07 14:32:24 --> Controller Class Initialized
INFO - 2017-03-07 14:32:24 --> Model Class Initialized
INFO - 2017-03-07 14:32:24 --> Database Driver Class Initialized
INFO - 2017-03-07 14:32:24 --> Model Class Initialized
INFO - 2017-03-07 14:32:24 --> Model Class Initialized
INFO - 2017-03-07 14:32:24 --> Helper loaded: form_helper
INFO - 2017-03-07 14:32:24 --> Form Validation Class Initialized
INFO - 2017-03-07 14:32:24 --> Language file loaded: language/english/form_validation_lang.php
ERROR - 2017-03-07 14:32:24 --> Severity: Notice --> Undefined variable: test_id F:\Work\GMP\GmpWeb\api\models\Test_model.php 184
INFO - 2017-03-07 14:32:24 --> Final output sent to browser
DEBUG - 2017-03-07 14:32:24 --> Total execution time: 0.3055
INFO - 2017-03-07 14:32:57 --> Config Class Initialized
INFO - 2017-03-07 14:32:57 --> Hooks Class Initialized
DEBUG - 2017-03-07 14:32:57 --> UTF-8 Support Enabled
INFO - 2017-03-07 14:32:57 --> Utf8 Class Initialized
INFO - 2017-03-07 14:32:57 --> URI Class Initialized
INFO - 2017-03-07 14:32:57 --> Router Class Initialized
INFO - 2017-03-07 14:32:57 --> Output Class Initialized
INFO - 2017-03-07 14:32:57 --> Security Class Initialized
DEBUG - 2017-03-07 14:32:57 --> Global POST, GET and COOKIE data sanitized
INFO - 2017-03-07 14:32:57 --> Input Class Initialized
INFO - 2017-03-07 14:32:57 --> Language Class Initialized
INFO - 2017-03-07 14:32:57 --> Loader Class Initialized
INFO - 2017-03-07 14:32:57 --> Controller Class Initialized
INFO - 2017-03-07 14:32:57 --> Model Class Initialized
INFO - 2017-03-07 14:32:57 --> Database Driver Class Initialized
INFO - 2017-03-07 14:32:57 --> Model Class Initialized
INFO - 2017-03-07 14:32:57 --> Model Class Initialized
INFO - 2017-03-07 14:32:57 --> Helper loaded: form_helper
INFO - 2017-03-07 14:32:57 --> Form Validation Class Initialized
INFO - 2017-03-07 14:32:57 --> Language file loaded: language/english/form_validation_lang.php
INFO - 2017-03-07 14:32:58 --> Final output sent to browser
DEBUG - 2017-03-07 14:32:58 --> Total execution time: 0.3011
