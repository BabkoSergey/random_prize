-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 29 2018 г., 13:42
-- Версия сервера: 5.7.24-0ubuntu0.16.04.1
-- Версия PHP: 7.1.11-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test-assignment-php`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cashes`
--

CREATE TABLE `cashes` (
  `id` int(10) UNSIGNED NOT NULL,
  `avalible` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `reserved` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `cach_to_point` decimal(5,3) UNSIGNED NOT NULL DEFAULT '2.500',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cashes`
--

INSERT INTO `cashes` (`id`, `avalible`, `reserved`, `cach_to_point`, `created_at`, `updated_at`) VALUES
(1, 100000, 0, '2.500', NULL, '2018-10-29 09:42:01');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_10_28_132146_create_types_table', 1),
(4, '2018_10_28_132646_create_cashes_table', 1),
(5, '2018_10_28_132707_create_products_table', 1),
(6, '2018_10_28_132843_create_ranges_table', 1),
(7, '2018_10_28_132912_create_prizes_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `prizes`
--

CREATE TABLE `prizes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `type_id` int(10) UNSIGNED NOT NULL,
  `value` int(10) UNSIGNED NOT NULL,
  `status` enum('pending','success','faild','discard') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `prizes`
--

INSERT INTO `prizes` (`id`, `user_id`, `type_id`, `value`, `status`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1572, 'success', 'Change 629 to pts by User', '2018-10-29 09:41:56', '2018-10-29 09:42:01');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avalible` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `reserved` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `avalible`, `reserved`, `created_at`, `updated_at`) VALUES
(1, 'Book', 152, 0, NULL, NULL),
(2, 'Phone', 48, 0, NULL, NULL),
(3, 'Tablet', 18, 0, NULL, NULL),
(4, 'Car', 0, 0, NULL, NULL),
(5, 'House', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `ranges`
--

CREATE TABLE `ranges` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_id` int(10) UNSIGNED NOT NULL,
  `min` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `max` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `ranges`
--

INSERT INTO `ranges` (`id`, `type_id`, `min`, `max`, `created_at`, `updated_at`) VALUES
(1, 1, 100, 10000, NULL, NULL),
(2, 2, 10, 1000, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `types`
--

CREATE TABLE `types` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `show` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `types`
--

INSERT INTO `types` (`id`, `type`, `show`, `created_at`, `updated_at`) VALUES
(1, 'point', 1, NULL, NULL),
(2, 'cash', 1, NULL, NULL),
(3, 'product', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `banking` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `amount`, `banking`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@localdomain.dev', 'admin', NULL, '$2y$10$iyQYIy1aPp3jjFv.s.862utLB22ncLwcQvwnMg9OcV08GGieHt61y', 'PA1bDGk8r6AP2G2Cmh8pgb5BspaCYXY2kauSGetc72eoTvPN8XAH7I7Jtox7', 0, NULL, '2018-10-29 09:38:38', '2018-10-29 09:38:38'),
(2, 'Test 1', 'tester1@localdomain.dev', 'user', NULL, '$2y$10$pNmNSWlKAw5/qvG6sUFBreyjnCb0NKf1e7syUZH0DTwKE/opHqFti', NULL, 1572, NULL, '2018-10-29 09:38:55', '2018-10-29 09:42:01');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cashes`
--
ALTER TABLE `cashes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `prizes`
--
ALTER TABLE `prizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prizes_user_id_foreign` (`user_id`),
  ADD KEY `prizes_type_id_foreign` (`type_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_name_unique` (`name`);

--
-- Индексы таблицы `ranges`
--
ALTER TABLE `ranges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ranges_type_id_foreign` (`type_id`);

--
-- Индексы таблицы `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `types_type_unique` (`type`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cashes`
--
ALTER TABLE `cashes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `prizes`
--
ALTER TABLE `prizes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `ranges`
--
ALTER TABLE `ranges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `types`
--
ALTER TABLE `types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `prizes`
--
ALTER TABLE `prizes`
  ADD CONSTRAINT `prizes_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prizes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `ranges`
--
ALTER TABLE `ranges`
  ADD CONSTRAINT `ranges_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
