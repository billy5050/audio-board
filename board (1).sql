-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2025-01-31 16:16:40
-- サーバのバージョン： 10.4.27-MariaDB
-- PHP のバージョン: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `board`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `email`, `content`) VALUES
(1, 13, '', 'いつもサイト運営ありがとうございます！');

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `thread_id`, `content`, `created_by`, `created_at`) VALUES
(3, 18, '再生機器はiphone11です。\r\n住んでいる場所が田舎なので、試聴は出来ません。', 7, '2025-01-22 13:49:13'),
(4, 18, '再生機器はiphone11です。\r\n住んでいる場所が田舎なので、試聴は出来ません。', 7, '2025-01-22 13:53:04'),
(5, 18, '草', 7, '2025-01-22 14:44:03'),
(6, 18, '草', 7, '2025-01-22 14:44:15'),
(7, 18, 'ああああああああああ！', 7, '2025-01-22 14:45:47'),
(8, 18, 'マジレスすると、ankerのliberty 4 proでいいよ', 7, '2025-01-22 14:53:57'),
(10, 19, 'おれは、pc→デジタルケーブル→zen can →4.4mmバランス→zen dac→純正ケーブル→t3-01のアンバランスで聞いてる。\r\nこれ以上は費用対効果も少ないだろうし、今のところはこれでゴールかな。', 8, '2025-01-22 17:09:10'),
(11, 19, 'そのくらいじゃ、天井までいきませんよ...。上流を整えればまだまだ伸びます。\r\n是非とも、あなたにはミドルハイくらいのアンプを買ってほしいですね。音像がまるで違います。', 9, '2025-01-22 17:30:18'),
(12, 19, '試聴だけおじさんじゃないなら、自分の環境も一緒にうｐ。', 8, '2025-01-23 09:21:54'),
(14, 19, 'denonのサウンドバーポン置きのワイ高みの見物', 6, '2025-01-23 11:05:33'),
(15, 18, 'iphoneならairpods pro無印は安定だね', 6, '2025-01-23 11:07:44'),
(16, 18, '最近のワイヤレスも全体的に性能良くなってきてるし、5千円も出せばある程度のものの買えそう。\r\n新しめのairfunとかでいいんじゃない？', 10, '2025-01-23 16:20:37'),
(17, 20, 'やはり定番ですが、hd800sではないでしょうか。\r\nあの音場の広さは他のフラグシップヘッドホンとも一線を画すものがあります。', 9, '2025-01-24 09:17:47'),
(18, 19, '当方はHDV820とHD800sをXRLバランスで接続しています。\r\n音源はNASに格納したものを使っていますよ。\r\nノイズ対策にHDVの足にはネオジムを貼り付けてますね。', 9, '2025-01-24 09:28:38'),
(19, 27, '着け心地はオーテクが最高だろ、もはやあれはつけてるとはおもえない。', 10, '2025-01-24 10:02:40'),
(20, 24, 'ワシはKAN ULTRAだな。あの重さとデザインがたまらん。', 13, '2025-01-24 15:38:20'),
(21, 19, '@5 サンクス、HD800sとか羨ましいな！バランスケーブルは純正？', 8, '2025-01-30 11:19:20'),
(22, 34, '正直この辺はタブーな部分もあると思うけど、色んな意見を聞きたくなったので。', 7, '2025-01-30 11:43:05'),
(23, 27, '@1 そういや、新しくモニターヘッドホンでるよな。\r\n頭に着けるときの構造が変わってるらしいけど、前のモデルの装着感好きだったから少し不安だわ\r\n', 7, '2025-01-30 11:54:34'),
(24, 27, '@2 まじか、おれは逆に頭がでかくてあんまり合わなかったからそれはうれしいかも', 10, '2025-01-30 11:56:13'),
(25, 27, 'mdr-mv1もいいぞ、映画鑑賞にはこれが最適じゃないか', 13, '2025-01-30 11:59:43'),
(26, 18, 'おれはbose使ってるけど、ノイキャン強くて便利だよ。', 11, '2025-01-30 16:47:47'),
(27, 35, '高くなればなるほど、音は良くなりますよ。\r\nどのくらいの価格で考えていますか？', 10, '2025-01-30 16:49:50'),
(28, 35, '5万円までくらいで考えてます。いつもスマホで音楽を聴いてるのでもっと音質を良くしたくて', 11, '2025-01-30 16:51:33'),
(29, 35, '@2 今度からスレッドを作成する時に、値段のタグもつけておくとみんなが見つけやすいかも\r\nワイヤレスなら5万もあれば、だいぶいいのが買えるな\r\nそれとも有線で考えてる？', 7, '2025-01-30 16:53:48');

-- --------------------------------------------------------

--
-- テーブルの構造 `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT 'タグ名',
  `created_at` datetime DEFAULT current_timestamp() COMMENT '作成日時',
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日時',
  `type` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `tags`
--

INSERT INTO `tags` (`id`, `name`, `created_at`, `updated_at`, `type`) VALUES
(11, 'ワイヤレス', '2025-01-16 16:52:04', '2025-01-16 16:52:04', 1),
(12, 'ワイヤレスイヤホン', '2025-01-16 16:52:04', '2025-01-16 16:52:04', 1),
(13, 'ワイヤレスヘッドホン', '2025-01-16 16:52:04', '2025-01-16 16:52:04', 1),
(14, '有線', '2025-01-16 16:52:04', '2025-01-16 16:52:04', 1),
(15, '有線イヤホン', '2025-01-16 16:52:04', '2025-01-16 16:52:04', 1),
(16, '有線ヘッドホン', '2025-01-16 16:52:04', '2025-01-16 16:52:04', 1),
(17, 'イヤホン', '2025-01-16 16:52:04', '2025-01-16 16:52:04', 1),
(18, 'ヘッドホン', '2025-01-16 16:52:04', '2025-01-16 16:52:04', 1),
(19, 'DAC・アンプ', '2025-01-16 16:52:04', '2025-01-16 16:52:04', 1),
(20, '質問', '2025-01-16 16:52:04', '2025-01-16 16:52:04', 1),
(21, '～5千円', '2025-01-16 17:10:31', '2025-01-16 17:10:31', 0),
(22, '5千～2万円', '2025-01-16 17:10:31', '2025-01-16 17:10:31', 0),
(23, '2万～5万円', '2025-01-16 17:10:31', '2025-01-16 17:10:31', 0),
(24, '5万円～10万円前後', '2025-01-16 17:10:31', '2025-01-16 17:10:31', 0),
(25, '10万円～100万円前後', '2025-01-16 17:10:31', '2025-01-16 17:10:31', 0),
(26, '100万円以上', '2025-01-16 17:10:31', '2025-01-16 17:10:31', 0),
(36, 'スピーカー', '2025-01-24 10:05:47', '2025-01-24 10:05:47', 1),
(38, 'サウンドバー', '2025-01-24 10:06:21', '2025-01-24 10:06:21', 1),
(39, 'DAP', '2025-01-24 10:06:33', '2025-01-24 10:06:33', 1),
(41, 'その他', '2025-01-24 10:08:18', '2025-01-24 10:08:18', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `threads`
--

CREATE TABLE `threads` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `view_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `threads`
--

INSERT INTO `threads` (`id`, `title`, `created_by`, `created_at`, `updated_at`, `view_count`) VALUES
(18, '通学に使うワイヤレスのおすすめはありますか？', 7, '2025-01-22 10:54:30', '2025-01-30 11:28:56', 41),
(19, 'ぶっちゃけ、みんなどんな環境で音楽聞いてるの？', 8, '2025-01-22 15:44:21', '2025-01-27 11:06:03', 36),
(20, 'クラッシックを聞くのに最適なヘッドホンを決める', 10, '2025-01-23 11:30:31', '2025-01-30 16:37:11', 17),
(21, 'ONKYOの新製品みんなどう思う？', 10, '2025-01-23 11:32:10', '2025-01-23 11:32:10', 0),
(23, '【新年】今年オーディオの福袋買った？', 10, '2025-01-23 11:35:48', '2025-01-27 11:05:42', 6),
(24, '去年買った一番大きい買い物を共有しよう', 10, '2025-01-23 11:37:39', '2025-01-24 15:37:37', 1),
(25, 'fortniteにおすすめのイヤホンをおしえてほしいです', 11, '2025-01-23 11:39:22', '2025-01-23 11:39:43', 0),
(26, 'イヤモニについて語ろう', 10, '2025-01-23 16:28:51', '2025-01-27 11:06:12', 3),
(27, '【急募】みんなの側圧の緩いヘッドホン集まれ！', 10, '2025-01-23 16:31:47', '2025-01-31 11:36:35', 8),
(31, 'オーディオ沼に入る前の自分へ言いたいこと', 13, '2025-01-24 15:19:52', '2025-01-31 11:36:39', 2),
(33, '欲しい製品を挙げると、持ってる人が感想を教えてくれるスレ', 13, '2025-01-24 15:31:08', '2025-01-31 11:36:45', 4),
(34, '【真剣】オーディオの電源の話をしよう', 7, '2025-01-30 11:41:25', '2025-01-31 11:36:47', 4),
(35, '音質最強イヤホンってどれ？', 11, '2025-01-30 16:48:37', '2025-01-31 14:25:34', 6);

-- --------------------------------------------------------

--
-- テーブルの構造 `threads_tags`
--

CREATE TABLE `threads_tags` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `threads_tags`
--

INSERT INTO `threads_tags` (`id`, `thread_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(9, 18, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 18, 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 18, 21, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 18, 22, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 19, 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 20, 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 20, 24, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 20, 25, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 20, 26, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 21, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 21, 24, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 24, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 24, 14, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 25, 11, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 25, 12, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 25, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 25, 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 26, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 27, 14, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 27, 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 31, 41, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 33, 41, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 34, 41, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 35, 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `confirm_password` varchar(128) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `email`, `user_name`, `password`, `confirm_password`, `created_at`, `updated_at`) VALUES
(6, 'test@test', 'test', 'b9429a6f835dde44089ddf0ac656c06d1c436022d976a1349877b26ea2e45e24', 'b9429a6f835dde44089ddf0ac656c06d1c436022d976a1349877b26ea2e45e24', '2025-01-15 15:04:37', '2025-01-15 15:04:37'),
(7, 'takesi@takesi', 'takesi', 'a944a235aa4f7c4ad8fc0c84e9ec95a99510160586cff03bbec1c1a98e59e9ac', 'a944a235aa4f7c4ad8fc0c84e9ec95a99510160586cff03bbec1c1a98e59e9ac', '2025-01-21 09:05:43', '2025-01-21 09:05:43'),
(8, 'iida@iida', 'めっさん', '8dd4646b25c487e432fe937fedf5eb8d05604c1ab71cbd6f678a1ba6dc86af34', '8dd4646b25c487e432fe937fedf5eb8d05604c1ab71cbd6f678a1ba6dc86af34', '2025-01-22 15:28:35', '2025-01-22 15:28:35'),
(9, 'tennis@tennis', '越後マーリョ', '2813118cc28b6d1b6a5db2f06b3a3796d65bdc28a97d8fac8b9ebc06d9c01dcd', '2813118cc28b6d1b6a5db2f06b3a3796d65bdc28a97d8fac8b9ebc06d9c01dcd', '2025-01-22 17:20:04', '2025-01-22 17:20:04'),
(10, 'o@o', 'ジ・オ', '24a579e9a9a19798a6ba4293761697485b8864e63d42c7a7c7ff78697e8ad0d0', '24a579e9a9a19798a6ba4293761697485b8864e63d42c7a7c7ff78697e8ad0d0', '2025-01-23 11:28:04', '2025-01-23 11:28:04'),
(11, 'kid@kid', '将司', 'faf0f70a7efd2b6984cba753937d0ae8cbb2c164eb972ff91c66d570caa3b70a', 'faf0f70a7efd2b6984cba753937d0ae8cbb2c164eb972ff91c66d570caa3b70a', '2025-01-23 11:38:44', '2025-01-23 11:38:44'),
(12, 'panda@panda', 'パンズ', '6a1283a5061c1ced1783ee529bb24cc611f0137767ba1004795b57eeaa14011c', '6a1283a5061c1ced1783ee529bb24cc611f0137767ba1004795b57eeaa14011c', '2025-01-24 14:52:08', '2025-01-24 15:09:48'),
(13, 'q@q', 'チャムチャム', '306117ee2f3d41f09a89946b5ac3dc9dcf255e0ea737bcec73fb0bea94c703ff', '306117ee2f3d41f09a89946b5ac3dc9dcf255e0ea737bcec73fb0bea94c703ff', '2025-01-24 15:17:13', '2025-01-24 15:17:13');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thread_id` (`thread_id`),
  ADD KEY `created_by` (`created_by`);

--
-- テーブルのインデックス `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- テーブルのインデックス `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- テーブルのインデックス `threads_tags`
--
ALTER TABLE `threads_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thread_id` (`thread_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- テーブルの AUTO_INCREMENT `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- テーブルの AUTO_INCREMENT `threads`
--
ALTER TABLE `threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- テーブルの AUTO_INCREMENT `threads_tags`
--
ALTER TABLE `threads_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `threads`
--
ALTER TABLE `threads`
  ADD CONSTRAINT `threads_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- テーブルの制約 `threads_tags`
--
ALTER TABLE `threads_tags`
  ADD CONSTRAINT `threads_tags_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `threads_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
