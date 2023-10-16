<?php

namespace Muz\Rector\Rule;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Type\ObjectType;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class NodeFinderForTesting extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replaces calls to a method with a chain of calls.',
            [
                new CodeSample('badCode', 'goodCode')
            ]
        );
    }

    public function getNodeTypes(): array
    {
        return [MethodCall::class];
    }

    public function refactor(Node $node)
    {
        if (!isset($node->name)) {
            return null;
        }
        $callName = $this->getName($node->name);
        if ($callName === null) {
            return null;
        }

        $methodCallRename = [
            'fqcn' => 'Muz\Beesite\Base\Entity\Base\CandidateBase',
            'oldmethod' => 'getRelatedId',
            'newmethodchain' => ['getRelated', 'getId',],
        ];

        if ($node instanceof MethodCall && $callName === $methodCallRename['oldmethod']) {
            if ($this->nodeTypeResolver->isObjectType($node->var, new ObjectType($methodCallRename['fqcn']))) {
                $newMethodNames = $methodCallRename['newmethodchain'];
                $node->name = new Node\Identifier(array_shift($newMethodNames));

                if (count($newMethodNames)) {
                    foreach ($newMethodNames as $additionalMethodCall) {
                        $node = new MethodCall($node, new Node\Identifier($additionalMethodCall));
                    }
                }

                return $node;
            }
        }

        return null;
    }
}
