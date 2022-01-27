<?php
/**
 * @package    Evangelische Termine Teaser
 *
 * @author     Daniel Städtler - github_herrpfarrer@posteo.de
 * @copyright  Copyright 2022 Daniel Städtler. – All rights reserved.
 * @license    GNU General Public License version 3
 * @link       https://github.com/herrpfarrer/Evangelische-Termine-Teaser
 */

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use EvangelischeTermine\Module\EvangelischeTermineTeaser\Site\Helper\GetTeaserHelper;

$teaser = GetTeaserHelper::getTeaser($params);

require ModuleHelper::getLayoutPath('mod_etteaser', $params->get('layout', 'default'));