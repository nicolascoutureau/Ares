<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/02/2015
 * Time: 10:49
 */

namespace Ares\CoreBundle\Twig;

class DateExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('intl_date', array($this, 'intlDate')),
        );
    }

    public function intlDate($date, $format = 'MMM', $locale = "fr_FR")
    {
        if (!$date instanceof \DateTime) {
            $date = new \DateTime($date);
        }

        $fmt = new \IntlDateFormatter( $locale, \IntlDateFormatter::FULL, \IntlDateFormatter::FULL, 'Europe/Paris', \IntlDateFormatter::GREGORIAN, $format);
        return $fmt->format($date);
    }

    public function getName()
    {
        return 'date_extension';
    }
}