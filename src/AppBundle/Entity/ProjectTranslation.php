<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;


/**
 * @ORM\Table(name="rs_project_translations", indexes={
 *      @ORM\Index(name="rs_project_translation_idx", columns={"locale", "object_class", "field", "foreign_key"})
 * })
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @author rodrigo
 */
class ProjectTranslation extends AbstractTranslation
{

    
}
