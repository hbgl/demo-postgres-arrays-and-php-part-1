<?php

namespace App\Build;

use PhpParser\Node;
use PhpParser\NodeFinder;
use PhpParser\ParserFactory;

class ComposerScripts
{
    /**
     * Handle the post-autoload-dump Composer event.
     *
     * @param  \Composer\Script\Event  $event
     * @return void
     */
    public static function postAutoloadDump($event)
    {
        require_once $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';

        self::replaceQueryBuilderCleanBindingsFunction($event);
    }

    /**
     * Replace the body of the cleanBindings function of the query builder
     * with a custom implementation. It goes without saying that you should
     * probably not run this code in production.
     *
     * @param  \Composer\Script\Event  $event
     * @return void
     */
    private static function replaceQueryBuilderCleanBindingsFunction($event)
    {
        $builderPath = $event->getComposer()->getConfig()->get('vendor-dir').'/laravel/framework/src/Illuminate/Database/Query/Builder.php';
        $code = file_get_contents($builderPath);

        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        $stmts = $parser->parse($code);

        $nodeFinder = new NodeFinder();

        /** @var \PhpParser\Node\Stmt\Class_ */
        $builderClass = $nodeFinder->findFirstInstanceOf($stmts, Node\Stmt\Class_::class);

        /** @var \PhpParser\Node\Stmt\ClassMethod */
        $cleanBindingsFunction = $nodeFinder->findFirst($builderClass->stmts, function(Node $node) {
            return $node instanceof Node\Stmt\ClassMethod
                && $node->name->toString() === 'cleanBindings';
        });

        // The new cleanBindings function body.
        $newCleanBindingsCode = <<<'PHP'
<?php
        $items = [];
        foreach ($bindings as $binding) {
            if ($binding instanceof \App\Database\ParameterizedExpression) {
                foreach ($binding->getBindings() as $b) {
                    $items[] = $b;
                }
            } else if (!($binding instanceof Expression)) {
                $items[] = $binding;
            }
        }
        return $items;
PHP
;
        // Set the new function body.
        $newCleanBindingsStmts = $parser->parse($newCleanBindingsCode);
        $cleanBindingsFunction->stmts = $newCleanBindingsStmts;

        // Dump altered Builder source code.
        $prettyPrinter = new \PhpParser\PrettyPrinter\Standard();
        $newCode = $prettyPrinter->prettyPrintFile($stmts);
        file_put_contents($builderPath, $newCode);
    }
}
