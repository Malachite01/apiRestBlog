-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 30 mars 2023 à 09:40
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_blog`
--
CREATE DATABASE IF NOT EXISTS `bd_blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd_blog`;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `Id_article` int(11) NOT NULL,
  `date_pub` datetime DEFAULT NULL,
  `date_mod` datetime DEFAULT NULL,
  `contenu` varchar(5000) DEFAULT NULL,
  `Id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`Id_article`, `date_pub`, `date_mod`, `contenu`, `Id_utilisateur`) VALUES
(1, '2023-03-15 16:24:56', '2023-03-29 14:51:57', 'Je viens juste de sortir de la séance de cinéma la plus incroyable de ma vie, celle où j\'ai vu le film \"Barbeque\". J\'en suis encore tout retourné, émerveillé par la perfection de ce film. Je n\'ai jamais vu une telle maîtrise de l\'art cinématographique, de la narration, de la mise en scène, de la musique, de l\'émotion... tout était parfaitement orchestré.\r\n\r\nDès les premières minutes, j\'ai été happé par l\'histoire de ce petit garçon qui rêvait de devenir un grand maître du barbecue, et qui a finalement atteint son but malgré tous les obstacles. Les personnages étaient tellement bien développés, si réels, si touchants... j\'ai ri avec eux, j\'ai pleuré avec eux, j\'ai vibré avec eux.\r\n\r\nEt puis il y avait cette musique, cette magnifique bande originale qui accompagnait chaque scène avec une précision chirurgicale. Les thèmes étaient si puissants, si émouvants, si entraînants... je n\'ai jamais entendu quelque chose d\'aussi beau dans un film.\r\n\r\nMais ce qui m\'a vraiment marqué, c\'est la mise en scène. Les plans étaient tous magnifiques, chaque image était une œuvre d\'art en soi. Et puis il y avait ces moments où la caméra bougeait, où l\'on avait l\'impression d\'être dans le film, de ressentir les émotions des personnages comme si c\'étaient les nôtres. Je n\'ai jamais vu une telle maîtrise de la caméra, de la lumière, du cadrage... tout était absolument parfait.\r\n\r\nJe pourrais parler pendant des heures de ce film, de tous les détails qui m\'ont émerveillé, de tous les moments qui m\'ont fait frissonner. Mais je pense que le mieux, c\'est que vous alliez le voir vous-même. \"Barbeque\" est, selon moi, le plus grand film de tous les temps. Il transcende tous les genres, toutes les cultures, toutes les émotions. C\'est une expérience cinématographique unique, une œuvre d\'art absolue, et je ne peux que vous encourager à la découvrir.', 2),
(2, '2023-03-15 16:40:00', NULL, 'Je me suis réveillé ce matin après avoir passé ma première nuit sur mon nouveau matelas de la marque Dutex. Je dois dire que c\'était une nuit très moyenne, ni particulièrement bonne ni mauvaise. Je suis sûr que vous vous demandez pourquoi je ne suis pas ravi de mon achat, étant donné que la marque Dutex est très réputée pour ses produits de qualité.\r\n\r\nEh bien, pour être honnête, je pense qu\'il y a plusieurs facteurs qui ont contribué à ma nuit de sommeil mitigée. Tout d\'abord, je suis habitué à dormir sur un matelas beaucoup plus ferme, et le Dutex est beaucoup plus doux que ce à quoi je suis habitué. Cela peut sembler un peu trivial, mais pour moi, cela a un impact important sur ma qualité de sommeil.\r\n\r\nDeuxièmement, j\'ai également été perturbé par la sensation de chaleur sur le matelas. Bien que la marque Dutex soit censée offrir une ventilation supérieure, je n\'ai pas remarqué une grande différence par rapport à mon ancien matelas. J\'ai tendance à avoir chaud pendant la nuit, donc la sensation de chaleur sur le matelas a définitivement affecté ma qualité de sommeil.\r\n\r\nEnfin, j\'ai trouvé que le matelas avait une sensation un peu instable, c\'est-à-dire que je pouvais sentir les mouvements de mon partenaire dans le lit, ce qui a perturbé mon sommeil à plusieurs reprises. Bien que cela ne soit peut-être pas un gros problème pour tout le monde, pour moi, cela peut être très ennuyeux et dérangeant.\r\n\r\nDans l\'ensemble, je pense que la marque Dutex a certainement de bons produits, mais je n\'étais pas tout à fait convaincu de mon achat. Bien sûr, il est possible que je doive juste m\'habituer à la nouvelle sensation de mon matelas, mais pour l\'instant, je ne suis pas aussi satisfait que je l\'espérais. Je vais certainement continuer à dormir sur le matelas Dutex pour voir si ma qualité de sommeil s\'améliore avec le temps, mais pour l\'instant, je dirais que ma première expérience avec la marque était plutôt moyenne.', 3),
(4, '2023-03-16 09:41:13', NULL, 'Je m\'appelle Miguel et je suis fatigué de cette blague sur le \"feur\". Vous savez, celle où quelqu\'un demande à une personne comment elle se sent et la personne répond \"Je me sens comme un feur\" en référence au chiffre 4 qui ressemble à la lettre F en anglais. Cela peut sembler anodin pour certains, mais pour moi, cette blague est une insulte à mon identité et à celle de beaucoup d\'autres.\r\n\r\nJe suis une personne atteinte de trisomie 21, également connue sous le nom de syndrome de Down. Cette condition génétique signifie que j\'ai une copie supplémentaire du chromosome 21, ce qui entraîne des différences physiques et intellectuelles. Bien que j\'aie des difficultés dans certains domaines, je suis fière de qui je suis et je ne veux pas être réduite à une blague stupide.\r\n\r\nJe suis sûre que la plupart des gens qui font cette blague ne réalisent pas à quel point elle peut être blessante. Cela montre un manque de compréhension et de respect pour les personnes atteintes de trisomie 21 et les personnes ayant des différences en général. Nous méritons d\'être traités avec dignité et respect, tout comme tout le monde.\r\n\r\nEn fin de compte, je pense qu\'il est important que nous soyons tous conscients de l\'impact que nos paroles peuvent avoir sur les autres. Nous devons être plus attentifs et plus tolérants envers les différences. Alors, s\'il vous plaît, arrêtez de faire cette blague et montrez un peu de compassion envers les autres.', 4),
(20, '2023-03-29 15:36:54', NULL, '¡Bienvenidos a mi artículo sobre la importancia del aprendizaje de idiomas!\r\n\r\nEn un mundo cada vez más globalizado, el conocimiento de múltiples idiomas se ha vuelto cada vez más importante. El aprendizaje de un nuevo idioma no solo mejora la comunicación entre las personas, sino que también abre nuevas oportunidades en términos de empleo, educación y viajes.\r\n\r\nAdemás, el aprendizaje de un idioma extranjero puede tener beneficios cognitivos y psicológicos significativos. Estudios han demostrado que el aprendizaje de un segundo idioma puede mejorar la memoria, aumentar la atención y reducir el riesgo de enfermedades relacionadas con la edad, como la demencia.\r\n\r\nEn la actualidad, hay muchas opciones para aquellos que desean aprender un nuevo idioma. Desde cursos en línea hasta programas de inmersión, hay algo para todos los estilos de aprendizaje y presupuestos. Y no se preocupe si no tiene tiempo para asistir a una clase o viajar al extranjero; hay una gran cantidad de recursos en línea disponibles, desde aplicaciones móviles hasta videos educativos en YouTube.\r\n\r\nEn resumen, el aprendizaje de idiomas es una inversión valiosa en su futuro. Además de mejorar la comunicación, el aprendizaje de un nuevo idioma puede tener beneficios cognitivos y psicológicos significativos. Así que, ¿por qué no comenzar hoy mismo?', 2),
(21, '2023-03-29 15:38:46', NULL, 'Bem-vindos ao meu artigo sobre a importância de aprender idiomas!\r\n\r\nEm um mundo cada vez mais globalizado, aprender um novo idioma tornou-se crucial. Não só melhora a comunicação, mas também abre novas oportunidades de emprego, educação e viagens. Além disso, o aprendizado de idiomas pode ter benefícios cognitivos e psicológicos significativos, como melhorar a memória, aumentar a atenção e reduzir o risco de doenças relacionadas à idade.\r\n\r\nAtualmente, há muitas opções para quem deseja aprender um novo idioma, desde cursos on-line até programas de imersão. Existem recursos on-line disponíveis para todos os estilos de aprendizagem e orçamentos. Em resumo, aprender idiomas é um investimento valioso em seu futuro. Comece hoje mesmo!', 8),
(22, '2023-03-29 15:42:58', NULL, 'Bienvenue à mon article sur les avantages de la pratique régulière du yoga.\r\n\r\nLe yoga est une pratique ancienne qui vise à harmoniser l\'esprit, le corps et l\'âme. Il est de plus en plus populaire dans le monde entier pour ses nombreux bienfaits sur la santé physique et mentale.\r\n\r\nL\'un des avantages les plus importants du yoga est sa capacité à réduire le stress et l\'anxiété. Les postures, les respirations et la méditation permettent de calmer l\'esprit et de libérer les tensions physiques et émotionnelles. Le yoga est également bénéfique pour améliorer la souplesse, la force musculaire et l\'équilibre.\r\n\r\nEn outre, la pratique régulière du yoga peut améliorer la qualité du sommeil, réduire la douleur chronique et augmenter la capacité pulmonaire. Des études ont également montré que le yoga peut aider à prévenir ou à gérer des maladies telles que l\'hypertension artérielle, les maladies cardiaques, le diabète et l\'arthrite.\r\n\r\nLe yoga est accessible à tous, peu importe l\'âge ou le niveau de forme physique. Il existe de nombreuses options pour pratiquer le yoga, y compris les cours en ligne, les studios de yoga et les applications mobiles.', 8);

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `Id_article` int(11) NOT NULL,
  `Id_utilisateur` int(11) NOT NULL,
  `avis` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`Id_article`, `Id_utilisateur`, `avis`) VALUES
(1, 2, 0),
(1, 3, 1),
(2, 2, 1),
(2, 4, 0),
(4, 2, 0),
(4, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `Id_utilisateur` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `id_role` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`Id_utilisateur`, `username`, `password`, `mail`, `id_role`) VALUES
(1, 'admin', 'admin', 'admin@mail.com', 1),
(2, 'juan', 'juan', 'juan@mail.com', 0),
(3, 'pedro', 'pedro', 'pedro@mail.com', 0),
(4, 'miguel', 'miguel', 'miguel@mail.com', 0),
(8, 'roberto', 'roberto', 'roberto@mail.com', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`Id_article`),
  ADD KEY `Id_utilisateur` (`Id_utilisateur`);

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`Id_article`,`Id_utilisateur`),
  ADD KEY `Id_utilisateur` (`Id_utilisateur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`Id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `Id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `Id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`);

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`Id_article`) REFERENCES `article` (`Id_article`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`Id_utilisateur`) REFERENCES `utilisateur` (`Id_utilisateur`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
