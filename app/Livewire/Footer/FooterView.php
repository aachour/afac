<?php

namespace App\Livewire\Footer;

use App\Models\Footer;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FooterView extends Component
{
    use AuthorizesRequests;

    public $footer;

    public $showModal = false;
    public $editingCol = null; // 1, 2, or 3

    // Shared form fields for the currently-edited column
    public string $colText         = '';
    public string $colTextArabic   = '';
    public array  $colLinks        = [];
    public array  $colLinksArabic  = [];

    public function mount()
    {
        $this->authorize('color-list');
        $this->footer = Footer::first() ?? new Footer();
    }

    // ─── Modal ──────────────────────────────────────────────────────────────

    public function openModal(int $col): void
    {
        $this->editingCol      = $col;
        $this->colText         = $this->footer->{"col{$col}"}               ?? '';
        $this->colTextArabic   = $this->footer->{"col{$col}_arabic"}        ?? '';
        $this->colLinks        = $this->parseLinks($this->footer->{"col{$col}_links"});
        $this->colLinksArabic  = $this->parseLinks($this->footer->{"col{$col}_arabic_links"});
        $this->showModal       = true;
    }

    public function closeModal(): void
    {
        $this->showModal      = false;
        $this->editingCol     = null;
        $this->colText        = '';
        $this->colTextArabic  = '';
        $this->colLinks       = [];
        $this->colLinksArabic = [];
    }

    // ─── Link rows ──────────────────────────────────────────────────────────

    public function addLink(): void
    {
        $this->colLinks[] = ['title' => '', 'link' => ''];
    }

    public function removeLink(int $index): void
    {
        array_splice($this->colLinks, $index, 1);
        $this->colLinks = array_values($this->colLinks);
    }

    public function addArabicLink(): void
    {
        $this->colLinksArabic[] = ['title' => '', 'link' => ''];
    }

    public function removeArabicLink(int $index): void
    {
        array_splice($this->colLinksArabic, $index, 1);
        $this->colLinksArabic = array_values($this->colLinksArabic);
    }

    // ─── Save ───────────────────────────────────────────────────────────────

    public function save(): void
    {
        $col = $this->editingCol;

        $this->footer->{"col{$col}"}              = $this->colText;
        $this->footer->{"col{$col}_arabic"}       = $this->colTextArabic;
        $this->footer->{"col{$col}_links"}        = array_values($this->colLinks);
        $this->footer->{"col{$col}_arabic_links"} = array_values($this->colLinksArabic);

        $this->footer->save();
        $this->footer->refresh();

        session()->flash('message', "Column {$col} updated successfully.");
        $this->closeModal();
    }

    // ─── Helpers ────────────────────────────────────────────────────────────

    private function parseLinks(mixed $value): array
    {
        if (empty($value)) {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function render()
    {
        return view('livewire.footer.footer-view');
    }
}
