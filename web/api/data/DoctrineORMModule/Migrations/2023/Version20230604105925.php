<?php

declare(strict_types=1);

namespace Application;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230604105925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `data` (id INT AUTO_INCREMENT NOT NULL, company VARCHAR(45) DEFAULT NULL COMMENT \'公司名稱\', purchase_date DATE DEFAULT NULL COMMENT \'進貨日期\', item_name VARCHAR(45) DEFAULT NULL COMMENT \'品項名稱\', `type` VARCHAR(45) DEFAULT NULL COMMENT \'基金\', `a` INT DEFAULT NULL COMMENT \'上日結存\', b INT DEFAULT NULL COMMENT \'上日粒數\', `c` INT DEFAULT NULL COMMENT \'進貨量\', d INT DEFAULT NULL COMMENT \'進貨粒數\', e INT DEFAULT NULL COMMENT \'進料處理量\', f INT DEFAULT NULL COMMENT \'處理粒數\', `g` INT DEFAULT NULL COMMENT \'本日盤盈虧\', h INT DEFAULT NULL COMMENT \'盤盈虧粒數\', i INT DEFAULT NULL COMMENT \'本日結存\', j INT DEFAULT NULL COMMENT \'本日粒數\', remarks LONGTEXT DEFAULT NULL COMMENT \'備註\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `data`');
    }
}
