<?php declare(strict_types=1);

namespace Vendor\renderView;

final class ViewRender
{
    public function __construct(
        private string $viewName,
        private ?array $data = null,
    ) {
        self::render($viewName, $data);
    }
    
    private static function render(string $viewName, ?array $data): void
    {
        if (!self::fileVerify($viewName)) {
            echo "A view '{$viewName}' solicitada não existe. Verifique!";
            return;
        }
    
        if ($data) {
            $items = $data;
        }

        require __DIR__."/../../Views/{$viewName}.view.php";
    }

    private static function fileVerify(string $viewName): bool
    {
        return file_exists(__DIR__."/../../Views/{$viewName}.view.php");
    }

}
