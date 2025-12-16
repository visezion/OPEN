<?php

namespace Workdo\Churchly\Services;

use Illuminate\Support\Collection;

class AssetInventoryPdfGenerator
{
    public function generate(Collection $assets): string
    {
        $lines = [[
            __('Asset'),
            __('Code'),
            __('Category'),
            __('Branch'),
            __('Department'),
            __('Status'),
            __('Quantity'),
        ]];

        foreach ($assets as $asset) {
            $lines[] = [
                $this->sanitize($asset->asset_name),
                $this->sanitize($asset->asset_code),
                $this->sanitize($asset->category),
                $this->sanitize(optional($asset->branch)->name ?? __('Headquarters')),
                $this->sanitize(optional($asset->department)->name ?? __('General')),
                ucfirst($asset->status),
                number_format($asset->quantity),
            ];
        }

        $content = $this->buildStream($lines);

        $objects = [
            $this->buildCatalog(),
            $this->buildPages(),
            $this->buildPage(),
            $this->buildContents($content),
            $this->buildFont(),
        ];

        $buffer = "%PDF-1.4\n";
        $offsets = [];
        foreach ($objects as $obj) {
            $offsets[] = strlen($buffer);
            $buffer .= $obj;
        }

        $startxref = strlen($buffer);
        $xref = $this->buildXref($offsets);
        $trailer = $this->buildTrailer(count($objects), $startxref);

        $buffer .= $xref;
        $buffer .= $trailer;
        $buffer .= "%%EOF";

        return $buffer;
    }

    private function buildStream(array $lines): string
    {
        $stream = '';
        $stream .= "BT /F1 12 Tf 40 820 Td (" . $this->escape(__('Asset inventory') . " - " . now()->format('F j, Y H:i')) . ") Tj ET\n";
        $y = 790;

        foreach ($lines as $index => $cells) {
            $text = implode(' | ', $cells);
            $stream .= "BT /F1 10 Tf 40 {$y} Td ({$this->escape($text)}) Tj ET\n";
            $y -= $index === 0 ? 16 : 14;
            if ($y < 40) {
                break;
            }
        }

        return $stream;
    }

    private function buildCatalog(): string
    {
        return "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
    }

    private function buildPages(): string
    {
        return "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
    }

    private function buildPage(): string
    {
        return "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n";
    }

    private function buildContents(string $stream): string
    {
        $length = strlen($stream);
        return "4 0 obj\n<< /Length {$length} >>\nstream\n{$stream}endstream\nendobj\n";
    }

    private function buildFont(): string
    {
        return "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
    }

    private function buildXref(array $offsets): string
    {
        $xref = "xref\n0 " . (count($offsets) + 1) . "\n";
        $xref .= str_pad('0000000000', 10, '0') . " 65535 f \n";
        foreach ($offsets as $offset) {
            $xref .= sprintf('%010d 00000 n ' . "\n", $offset);
        }
        return $xref;
    }

    private function buildTrailer(int $count, int $startxref): string
    {
        return "trailer\n<< /Size " . ($count + 1) . " /Root 1 0 R >>\nstartxref\n{$startxref}\n";
    }

    private function sanitize(?string $value): string
    {
        $value = trim((string) $value);
        $value = preg_replace('/\s+/', ' ', $value);
        return mb_strimwidth($value, 0, 40, '...');
    }

    private function escape(string $text): string
    {
        $text = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
        return $text;
    }
}
