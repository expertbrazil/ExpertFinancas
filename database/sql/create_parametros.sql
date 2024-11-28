USE forge;

CREATE TABLE IF NOT EXISTS `parametros` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome_sistema` varchar(255) NOT NULL DEFAULT 'Expert Finanças',
    `logo_path` varchar(255) DEFAULT NULL,
    `cor_primaria` varchar(7) NOT NULL DEFAULT '#0d6efd',
    `cor_secundaria` varchar(7) NOT NULL DEFAULT '#6c757d',
    `cor_fundo` varchar(7) NOT NULL DEFAULT '#ffffff',
    `cor_texto` varchar(7) NOT NULL DEFAULT '#212529',
    `cor_navbar` varchar(7) NOT NULL DEFAULT '#212529',
    `cor_footer` varchar(7) NOT NULL DEFAULT '#212529',
    `email_contato` varchar(255) DEFAULT NULL,
    `telefone_contato` varchar(20) DEFAULT NULL,
    `texto_rodape` text DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir configuração inicial se a tabela estiver vazia
INSERT INTO `parametros` (`nome_sistema`, `cor_primaria`, `cor_secundaria`, `cor_fundo`, `cor_texto`, `cor_navbar`, `cor_footer`, `created_at`, `updated_at`)
SELECT 'Expert Finanças', '#0d6efd', '#6c757d', '#ffffff', '#212529', '#212529', '#212529', NOW(), NOW()
WHERE NOT EXISTS (SELECT 1 FROM `parametros` LIMIT 1);
