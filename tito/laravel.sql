-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql
-- Tiempo de generación: 26-11-2025 a las 01:53:04
-- Versión del servidor: 8.0.43
-- Versión de PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `laravel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acces_roles`
--

CREATE TABLE `acces_roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actions`
--

CREATE TABLE `actions` (
  `id` bigint UNSIGNED NOT NULL,
  `name_action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrator_users`
--

CREATE TABLE `administrator_users` (
  `id` bigint UNSIGNED NOT NULL,
  `userId` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `allergenes`
--

CREATE TABLE `allergenes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `allergies`
--

CREATE TABLE `allergies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `allergies_allergenes`
--

CREATE TABLE `allergies_allergenes` (
  `id` bigint UNSIGNED NOT NULL,
  `allergie_id` bigint UNSIGNED DEFAULT NULL,
  `allergene_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `allergies_records`
--

CREATE TABLE `allergies_records` (
  `id` bigint UNSIGNED NOT NULL,
  `id_record` bigint UNSIGNED DEFAULT NULL,
  `allergie_allergene_id` bigint UNSIGNED DEFAULT NULL,
  `severity` enum('Leve','Moderada','Grave') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Activa','Inactiva') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symptoms` text COLLATE utf8mb4_unicode_ci,
  `treatments` text COLLATE utf8mb4_unicode_ci,
  `diagnosis_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED DEFAULT NULL,
  `doctor_id` bigint UNSIGNED DEFAULT NULL,
  `receptionist_id` bigint UNSIGNED DEFAULT NULL,
  `services_id` bigint UNSIGNED NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('En curso','completada','cancelada','Sin confirmar','Confirmada','agendada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'agendada',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifications` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chronics_diseases`
--

CREATE TABLE `chronics_diseases` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chronic_disease_record`
--

CREATE TABLE `chronic_disease_record` (
  `id` bigint UNSIGNED NOT NULL,
  `id_record` bigint UNSIGNED DEFAULT NULL,
  `chronics_diseases_id` bigint UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consult_disease`
--

CREATE TABLE `consult_disease` (
  `id` bigint UNSIGNED NOT NULL,
  `id_medical_record` bigint UNSIGNED NOT NULL,
  `appointment_id` bigint UNSIGNED NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `symptoms` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `findings` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnosis_id` bigint UNSIGNED NOT NULL,
  `treatment_diagnosis` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `document_types`
--

CREATE TABLE `document_types` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `files_records`
--

CREATE TABLE `files_records` (
  `id` bigint UNSIGNED NOT NULL,
  `id_record` bigint UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` double NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_type_id` bigint UNSIGNED DEFAULT NULL,
  `upload_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `general_users`
--

CREATE TABLE `general_users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genre` enum('hombre','mujer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `typeUser_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medical_records`
--

CREATE TABLE `medical_records` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `creation_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medic_patient`
--

CREATE TABLE `medic_patient` (
  `id` bigint UNSIGNED NOT NULL,
  `medic_id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medic_users`
--

CREATE TABLE `medic_users` (
  `id` bigint UNSIGNED NOT NULL,
  `specialty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_ID` bigint UNSIGNED NOT NULL,
  `userId` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_26_100418_add_two_factor_columns_to_users_table', 1),
(5, '2025_10_16_010336_create_permissions_table', 1),
(6, '2025_10_16_010945_create_services_table', 1),
(7, '2025_10_16_032229_create_acces_roles_table', 1),
(8, '2025_10_16_203528_create_general_users_table', 1),
(9, '2025_10_16_203838_create_administrator_users_table', 1),
(10, '2025_10_16_204312_create_nurse_users_table', 1),
(11, '2025_10_16_204326_create_medic_users_table', 1),
(12, '2025_10_16_204340_create_patient_users_table', 1),
(13, '2025_10_16_204354_create_recepcionist_users_table', 1),
(14, '2025_10_17_023331_allergenes', 1),
(15, '2025_10_17_023718_create_appointments_table', 1),
(16, '2025_10_17_054716_create_medical_records_table', 1),
(17, '2025_10_17_055906_create_vital_signs_table', 1),
(18, '2025_10_17_056437_create_document_types_table', 1),
(19, '2025_10_17_060847_create_files_records_table', 1),
(20, '2025_10_17_231309_create_allergies_table', 1),
(21, '2025_10_17_232027_create_allergies_allergenes_table', 1),
(22, '2025_10_17_232233_create_chronics_diseases_table', 1),
(23, '2025_10_17_234935_create_chronic_disease_records_table', 1),
(24, '2025_10_17_235048_create_allergies_records_table', 1),
(25, '2025_10_18_051401_create_treatments_table', 1),
(26, '2025_10_18_051631_create_treatments_records_table', 1),
(27, '2025_10_18_235539_consult_disease', 1),
(28, '2025_11_17_191933_create_medic_patient_table', 1),
(29, '2025_11_24_000518_create_actions_table', 1),
(30, '2025_11_24_210952_create_role_permission_table', 1),
(31, '2025_11_24_234327_create_user_permissions_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nurse_users`
--

CREATE TABLE `nurse_users` (
  `id` bigint UNSIGNED NOT NULL,
  `turno` enum('matutino','vespertino','nocturno') COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patient_users`
--

CREATE TABLE `patient_users` (
  `id` bigint UNSIGNED NOT NULL,
  `userId` bigint UNSIGNED DEFAULT NULL,
  `DNI` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_Temporary` tinyint(1) NOT NULL DEFAULT '0',
  `temporary_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temporary_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userCode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name_permission` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcionist_users`
--

CREATE TABLE `recepcionist_users` (
  `id` bigint UNSIGNED NOT NULL,
  `turno` enum('matutino','vespertino','nocturno') COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_permission`
--

CREATE TABLE `role_permission` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('oyg0rRELGXSaG2MDP6PloBWYvEripZQaFyvyPm2T', NULL, '172.19.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidEJGdEFHazBzenZEQzVaS3MwUEZMZ0NuYUEwSjNkVXZkclZFZHhmZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1764121885);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `treatments`
--

CREATE TABLE `treatments` (
  `id` bigint UNSIGNED NOT NULL,
  `treatment_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('medication','therapy','surgery','lifestyle_change') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `treatments_records`
--

CREATE TABLE `treatments_records` (
  `id` bigint UNSIGNED NOT NULL,
  `id_record` bigint UNSIGNED NOT NULL,
  `treatment_id` bigint UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('En seguimiento','Completado','suspendido') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'En seguimiento',
  `prescribed_by` bigint UNSIGNED DEFAULT NULL,
  `appointment_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `actions_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vital_signs`
--

CREATE TABLE `vital_signs` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED DEFAULT NULL,
  `register_date` bigint UNSIGNED NOT NULL,
  `temperature` double DEFAULT NULL,
  `heart_rate` int DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `height` double DEFAULT NULL,
  `register_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acces_roles`
--
ALTER TABLE `acces_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `acces_roles_name_type_unique` (`name_type`);

--
-- Indices de la tabla `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `actions_name_action_unique` (`name_action`);

--
-- Indices de la tabla `administrator_users`
--
ALTER TABLE `administrator_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `administrator_users_userid_foreign` (`userId`);

--
-- Indices de la tabla `allergenes`
--
ALTER TABLE `allergenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `allergies`
--
ALTER TABLE `allergies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `allergies_allergenes`
--
ALTER TABLE `allergies_allergenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `allergies_allergenes_allergie_id_foreign` (`allergie_id`),
  ADD KEY `allergies_allergenes_allergene_id_foreign` (`allergene_id`);

--
-- Indices de la tabla `allergies_records`
--
ALTER TABLE `allergies_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `allergies_records_id_record_foreign` (`id_record`),
  ADD KEY `allergies_records_allergie_allergene_id_foreign` (`allergie_allergene_id`);

--
-- Indices de la tabla `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_patient_id_foreign` (`patient_id`),
  ADD KEY `appointments_doctor_id_foreign` (`doctor_id`),
  ADD KEY `appointments_receptionist_id_foreign` (`receptionist_id`),
  ADD KEY `appointments_services_id_foreign` (`services_id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `chronics_diseases`
--
ALTER TABLE `chronics_diseases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `chronic_disease_record`
--
ALTER TABLE `chronic_disease_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chronic_disease_record_id_record_foreign` (`id_record`),
  ADD KEY `chronic_disease_record_chronics_diseases_id_foreign` (`chronics_diseases_id`);

--
-- Indices de la tabla `consult_disease`
--
ALTER TABLE `consult_disease`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consult_disease_id_medical_record_foreign` (`id_medical_record`),
  ADD KEY `consult_disease_appointment_id_foreign` (`appointment_id`),
  ADD KEY `consult_disease_diagnosis_id_foreign` (`diagnosis_id`);

--
-- Indices de la tabla `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `files_records`
--
ALTER TABLE `files_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_records_id_record_foreign` (`id_record`),
  ADD KEY `files_records_document_type_id_foreign` (`document_type_id`);

--
-- Indices de la tabla `general_users`
--
ALTER TABLE `general_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `general_users_typeuser_id_foreign` (`typeUser_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_records_patient_id_foreign` (`patient_id`);

--
-- Indices de la tabla `medic_patient`
--
ALTER TABLE `medic_patient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medic_patient_medic_id_foreign` (`medic_id`),
  ADD KEY `medic_patient_patient_id_foreign` (`patient_id`);

--
-- Indices de la tabla `medic_users`
--
ALTER TABLE `medic_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medic_users_service_id_foreign` (`service_ID`),
  ADD KEY `medic_users_userid_foreign` (`userId`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `nurse_users`
--
ALTER TABLE `nurse_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nurse_users_userid_foreign` (`userId`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `patient_users`
--
ALTER TABLE `patient_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_users_userid_foreign` (`userId`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_permission_unique` (`name_permission`);

--
-- Indices de la tabla `recepcionist_users`
--
ALTER TABLE `recepcionist_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recepcionist_users_userid_foreign` (`userId`);

--
-- Indices de la tabla `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_permission_role_id_foreign` (`role_id`),
  ADD KEY `role_permission_permission_id_foreign` (`permission_id`);

--
-- Indices de la tabla `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `treatments_records`
--
ALTER TABLE `treatments_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `treatments_records_id_record_foreign` (`id_record`),
  ADD KEY `treatments_records_treatment_id_foreign` (`treatment_id`),
  ADD KEY `treatments_records_prescribed_by_foreign` (`prescribed_by`),
  ADD KEY `treatments_records_appointment_id_foreign` (`appointment_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_permissions_user_id_foreign` (`user_id`),
  ADD KEY `user_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_permissions_actions_id_foreign` (`actions_id`);

--
-- Indices de la tabla `vital_signs`
--
ALTER TABLE `vital_signs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vital_signs_patient_id_foreign` (`patient_id`),
  ADD KEY `vital_signs_register_date_foreign` (`register_date`),
  ADD KEY `vital_signs_register_by_foreign` (`register_by`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acces_roles`
--
ALTER TABLE `acces_roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `actions`
--
ALTER TABLE `actions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `administrator_users`
--
ALTER TABLE `administrator_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `allergenes`
--
ALTER TABLE `allergenes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `allergies`
--
ALTER TABLE `allergies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `allergies_allergenes`
--
ALTER TABLE `allergies_allergenes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `allergies_records`
--
ALTER TABLE `allergies_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `chronics_diseases`
--
ALTER TABLE `chronics_diseases`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `chronic_disease_record`
--
ALTER TABLE `chronic_disease_record`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consult_disease`
--
ALTER TABLE `consult_disease`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `files_records`
--
ALTER TABLE `files_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `general_users`
--
ALTER TABLE `general_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medic_patient`
--
ALTER TABLE `medic_patient`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medic_users`
--
ALTER TABLE `medic_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `nurse_users`
--
ALTER TABLE `nurse_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `patient_users`
--
ALTER TABLE `patient_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recepcionist_users`
--
ALTER TABLE `recepcionist_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `treatments`
--
ALTER TABLE `treatments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `treatments_records`
--
ALTER TABLE `treatments_records`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vital_signs`
--
ALTER TABLE `vital_signs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrator_users`
--
ALTER TABLE `administrator_users`
  ADD CONSTRAINT `administrator_users_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `general_users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `allergies_allergenes`
--
ALTER TABLE `allergies_allergenes`
  ADD CONSTRAINT `allergies_allergenes_allergene_id_foreign` FOREIGN KEY (`allergene_id`) REFERENCES `allergenes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `allergies_allergenes_allergie_id_foreign` FOREIGN KEY (`allergie_id`) REFERENCES `allergies` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `allergies_records`
--
ALTER TABLE `allergies_records`
  ADD CONSTRAINT `allergies_records_allergie_allergene_id_foreign` FOREIGN KEY (`allergie_allergene_id`) REFERENCES `allergies_allergenes` (`id`),
  ADD CONSTRAINT `allergies_records_id_record_foreign` FOREIGN KEY (`id_record`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `medic_users` (`id`),
  ADD CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patient_users` (`id`),
  ADD CONSTRAINT `appointments_receptionist_id_foreign` FOREIGN KEY (`receptionist_id`) REFERENCES `recepcionist_users` (`id`),
  ADD CONSTRAINT `appointments_services_id_foreign` FOREIGN KEY (`services_id`) REFERENCES `services` (`id`);

--
-- Filtros para la tabla `chronic_disease_record`
--
ALTER TABLE `chronic_disease_record`
  ADD CONSTRAINT `chronic_disease_record_chronics_diseases_id_foreign` FOREIGN KEY (`chronics_diseases_id`) REFERENCES `chronics_diseases` (`id`),
  ADD CONSTRAINT `chronic_disease_record_id_record_foreign` FOREIGN KEY (`id_record`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `consult_disease`
--
ALTER TABLE `consult_disease`
  ADD CONSTRAINT `consult_disease_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`),
  ADD CONSTRAINT `consult_disease_diagnosis_id_foreign` FOREIGN KEY (`diagnosis_id`) REFERENCES `chronics_diseases` (`id`),
  ADD CONSTRAINT `consult_disease_id_medical_record_foreign` FOREIGN KEY (`id_medical_record`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `files_records`
--
ALTER TABLE `files_records`
  ADD CONSTRAINT `files_records_document_type_id_foreign` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `files_records_id_record_foreign` FOREIGN KEY (`id_record`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `general_users`
--
ALTER TABLE `general_users`
  ADD CONSTRAINT `general_users_typeuser_id_foreign` FOREIGN KEY (`typeUser_id`) REFERENCES `acces_roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patient_users` (`id`);

--
-- Filtros para la tabla `medic_patient`
--
ALTER TABLE `medic_patient`
  ADD CONSTRAINT `medic_patient_medic_id_foreign` FOREIGN KEY (`medic_id`) REFERENCES `medic_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medic_patient_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patient_users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `medic_users`
--
ALTER TABLE `medic_users`
  ADD CONSTRAINT `medic_users_service_id_foreign` FOREIGN KEY (`service_ID`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `medic_users_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `general_users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `nurse_users`
--
ALTER TABLE `nurse_users`
  ADD CONSTRAINT `nurse_users_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `general_users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `patient_users`
--
ALTER TABLE `patient_users`
  ADD CONSTRAINT `patient_users_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `general_users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `recepcionist_users`
--
ALTER TABLE `recepcionist_users`
  ADD CONSTRAINT `recepcionist_users_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `general_users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `acces_roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `treatments_records`
--
ALTER TABLE `treatments_records`
  ADD CONSTRAINT `treatments_records_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treatments_records_id_record_foreign` FOREIGN KEY (`id_record`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `treatments_records_prescribed_by_foreign` FOREIGN KEY (`prescribed_by`) REFERENCES `medic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `treatments_records_treatment_id_foreign` FOREIGN KEY (`treatment_id`) REFERENCES `treatments` (`id`);

--
-- Filtros para la tabla `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `user_permissions_actions_id_foreign` FOREIGN KEY (`actions_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `general_users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vital_signs`
--
ALTER TABLE `vital_signs`
  ADD CONSTRAINT `vital_signs_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patient_users` (`id`),
  ADD CONSTRAINT `vital_signs_register_by_foreign` FOREIGN KEY (`register_by`) REFERENCES `nurse_users` (`id`),
  ADD CONSTRAINT `vital_signs_register_date_foreign` FOREIGN KEY (`register_date`) REFERENCES `appointments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
