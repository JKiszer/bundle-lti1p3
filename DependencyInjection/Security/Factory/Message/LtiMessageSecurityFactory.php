<?php

/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2020 (original work) Open Assessment Technologies SA;
 */

declare(strict_types=1);

namespace OAT\Bundle\Lti1p3Bundle\DependencyInjection\Security\Factory\Message;

use OAT\Bundle\Lti1p3Bundle\Security\Authentication\Provider\Message\LtiMessageAuthenticationProvider;
use OAT\Bundle\Lti1p3Bundle\Security\Firewall\Message\LtiMessageAuthenticationListener;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LtiMessageSecurityFactory implements SecurityFactoryInterface
{
    public function getPosition(): string
    {
        return 'pre_auth';
    }

    public function getKey(): string
    {
        return 'lti1p3_message';
    }

    // TODO provide type hints when we update the bundle with SF version >= 4.2
    public function create(
        ContainerBuilder $container,
        $id,
        $config,
        $userProvider,
        $defaultEntryPoint = null
    ): array {

        $providerId = sprintf('security.authentication.provider.%s.%s', $this->getKey(), $id);
        $container->setDefinition($providerId, new ChildDefinition(LtiMessageAuthenticationProvider::class));

        $listenerId = sprintf('security.authentication.listener.%s.%s', $this->getKey(), $id);
        $container->setDefinition($listenerId, new ChildDefinition(LtiMessageAuthenticationListener::class));

        return [$providerId, $listenerId, $defaultEntryPoint];
    }

    public function addConfiguration(NodeDefinition $node): void
    {
        return;
    }
}
