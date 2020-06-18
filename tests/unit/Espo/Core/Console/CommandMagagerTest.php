<?php
/************************************************************************
 * This file is part of EspoCRM.
 *
 * EspoCRM - Open Source CRM application.
 * Copyright (C) 2014-2020 Yuri Kuznetsov, Taras Machyshyn, Oleksiy Avramenko
 * Website: https://www.espocrm.com
 *
 * EspoCRM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * EspoCRM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with EspoCRM. If not, see http://www.gnu.org/licenses/.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "EspoCRM" word.
 ************************************************************************/

namespace tests\unit\Espo\Core\Console;

use tests\unit\ReflectionHelper;

class CommandMagagerTest extends \PHPUnit\Framework\TestCase
{

    protected function setUp() : void
    {
        $container = $this->container =
            $this->getMockBuilder('\\Espo\\Core\\Container')->disableOriginalConstructor()->getMock();

        $this->object = new \Espo\Core\Console\CommandManager($container);

        $this->reflection = new ReflectionHelper($this->object);
    }

    protected function tearDown() : void
    {
    }

    public function testGetParams1()
    {
        $argv = ['command.php', 'command-name', 'a1', 'a2', '--flag', '--flag-a', '-f', '--option-one=test'];
        $params = $this->reflection->invokeMethod('getParams', [$argv]);

        $this->assertEquals(['a1', 'a2'], $params['argumentList']);
        $this->assertEquals(['flag', 'flagA', 'f'], $params['flagList']);
        $this->assertEquals(['optionOne' => 'test'], $params['options']);
    }

    public function testGetParams2()
    {
        $argv = ['command-name', 'a1', 'a2', '--flag', '--flag-a', '-f', '--option-one=test'];
        $params = $this->reflection->invokeMethod('getParams', [$argv]);

        $this->assertEquals(['a1', 'a2'], $params['argumentList']);
        $this->assertEquals(['flag', 'flagA', 'f'], $params['flagList']);
        $this->assertEquals(['optionOne' => 'test'], $params['options']);
    }
}