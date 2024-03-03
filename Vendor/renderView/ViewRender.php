<?php declare(strict_types=1);

namespace Vendor\renderView;

final class ViewRender
{
    public function __construct(
        private string $viewName,
    ) {
        self::fileVerify($viewName);
    }

    private static function fileVerify(string $viewName): void
    {
        if (!file_exists(__DIR__."/../../Views/{$viewName}.view.php")) {
            echo "A view '{$viewName}' solicitada não existe. Verifique!";
            return;
        }

        require __DIR__."/../../Views/{$viewName}.view.php";
    }
}
